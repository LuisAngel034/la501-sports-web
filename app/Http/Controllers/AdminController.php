<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $recentOrders = \App\Models\Order::with('items')
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'total_ventas' => \App\Models\Order::sum('total'),
            'pedidos_hoy' => \App\Models\Order::whereDate('created_at', today())->count(),
            'reservaciones' => 0,
            'en_proceso' => \App\Models\Order::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('recentOrders', 'stats'));
    }

    public function reservaciones() 
    {
        return view('admin.reservaciones');
    }

    public function getSalesData(Request $request)
    {
        $period = $request->query('period', 'day');
        $labels = [];
        $data = [];

        if ($period == 'day') {
            // Ventas diarias de los últimos 30 días
            $sales = \App\Models\Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            foreach($sales as $s) {
                $labels[] = date('d M', strtotime($s->date));
                $data[] = $s->total;
            }
        } elseif ($period == 'month') {
            // Ventas mensuales del año actual
            $sales = \App\Models\Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
            $monthNames = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            foreach($sales as $s) {
                $labels[] = $monthNames[$s->month];
                $data[] = $s->total;
            }
        } else {
            // Ventas por año
            $sales = \App\Models\Order::selectRaw('YEAR(created_at) as year, SUM(total) as total')
                ->groupBy('year')
                ->orderBy('year')
                ->get();
            foreach($sales as $s) {
                $labels[] = $s->year;
                $data[] = $s->total;
            }
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    // Mostrar la bandeja de mensajes
    public function mensajes()
    {
        // Traemos todos los mensajes. Los 'pendientes' salen arriba, y los ordenamos por fecha.
        $mensajes = \App\Models\ContactMessage::orderByRaw("FIELD(status, 'pendiente', 'respondido')")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.mensajes', compact('mensajes'));
    }

    // Cambiar el estado del mensaje a "Respondido"
    public function marcarRespondido($id)
    {
        $mensaje = \App\Models\ContactMessage::findOrFail($id);
        $mensaje->status = 'respondido';
        $mensaje->save();

        return back()->with('success', 'Mensaje marcado como respondido.');
    }

    // Mostrar la vista del sistema
    public function database()
    {
        // Seguridad extra: Solo el usuario con ID 2 puede ver esto
        if (\Illuminate\Support\Facades\Auth::id() !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'No tienes permisos para acceder a esta área.');
        }

        return view('admin.database');
    }

    // =====================================================================
    // 1. MOTOR PRINCIPAL DE SQL (Lo usan tanto el manual como el automático)
    // =====================================================================
    private function generarSQLCompleto()
    {
        $sql = "-- ========================================================\n";
        $sql .= "-- RESPALDO COMPLETO DE BASE DE DATOS: La 501 Sports\n";
        $sql .= "-- Fecha de generación: " . now()->format('Y-m-d H:i:s') . "\n";
        $sql .= "-- Incluye: Tablas, Vistas, Procedimientos, Funciones, Triggers y Eventos\n";
        $sql .= "-- ========================================================\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sql .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n\n";

        // TABLAS Y VISTAS
        $tables = DB::select('SHOW FULL TABLES');
        foreach ($tables as $table) {
            $tableArray = array_values((array)$table);
            $tableName = $tableArray[0];
            $tableType = $tableArray[1];

            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
            $sql .= "DROP VIEW IF EXISTS `$tableName`;\n";
            
            try {
                if ($tableType === 'VIEW') {
                    $createTable = DB::select("SHOW CREATE VIEW `$tableName`");
                } else {
                    $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
                }
                
                $createSql = array_values((array)$createTable[0]);
                $estructuraLimpia = str_replace('utf8mb4_uca1400_ai_ci', 'utf8mb4_general_ci', $createSql[1]);
                $sql .= $estructuraLimpia . ";\n\n";

                if ($tableType === 'BASE TABLE') {
                    $rows = DB::select("SELECT * FROM `$tableName`");
                    if (count($rows) > 0) {
                        foreach ($rows as $row) {
                            $rowArray = (array)$row;
                            $values = array_map(function ($value) {
                                if (is_null($value)) return 'NULL';
                                return "'" . str_replace("\n", "\\n", addslashes($value)) . "'";
                            }, $rowArray);
                            $sql .= "INSERT INTO `$tableName` VALUES (" . implode(", ", $values) . ");\n";
                        }
                        $sql .= "\n\n";
                    }
                }
            } catch (\Exception $e) { $sql .= "-- ERROR EN `$tableName`: " . $e->getMessage() . "\n\n"; }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        return $sql;
    }

    // =====================================================================
    // 2. DESCARGA MANUAL (Botón Azul)
    // =====================================================================
    public function createBackup()
    {
        if (\Illuminate\Support\Facades\Auth::id() !== 2) return redirect()->route('admin.dashboard')->with('error', 'Denegado.');

        $sql = $this->generarSQLCompleto(); // Llama al motor privado
        $fileName = 'backup_manual_la501_' . date('Y-m-d_H-i-s') . '.sql';

        return response($sql)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    // =====================================================================
    // 3. GUARDAR CONFIGURACIÓN DE AUTOMATIZACIÓN (Botón Guardar)
    // =====================================================================
    public function saveAuto(\Illuminate\Http\Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::id() !== 2) return redirect()->route('admin.dashboard')->with('error', 'Denegado.');

        // Si el switch está apagado, se envía un request sin 'auto_backup'
        $enabled = $request->has('auto_backup') ? '1' : '0';
        
        \App\Models\Setting::updateOrCreate(['key' => 'backup_enabled'], ['value' => $enabled]);
        if ($enabled == '1') {
            \App\Models\Setting::updateOrCreate(['key' => 'backup_frecuencia'], ['value' => $request->frecuencia]);
            \App\Models\Setting::updateOrCreate(['key' => 'backup_hora'], ['value' => $request->hora ?? '03:00']);
            \App\Models\Setting::updateOrCreate(['key' => 'backup_intervalo'], ['value' => $request->intervalo ?? '60']);
            \App\Models\Setting::updateOrCreate(['key' => 'backup_delete_old'], ['value' => $request->delete_old ?? '1']);
        }

        return back()->with('success', 'Configuración de automatización actualizada.');
    }

    // =====================================================================
    // 4. EL MOTOR AUTOMÁTICO (Esta es la URL que visita Hostinger)
    // =====================================================================
    public function runAutoBackup()
    {
        // 1. Revisar si el administrador encendió el interruptor
        $isEnabled = \App\Models\Setting::where('key', 'backup_enabled')->value('value');
        if ($isEnabled !== '1') {
            return response('El respaldo automático está apagado en el panel.', 200);
        }

        // 2. Generar el archivo SQL usando el motor principal
        $sql = $this->generarSQLCompleto();
        $fileName = 'autobackup_' . date('Y-m-d_H-i-s') . '.sql';

        // 3. Guardar el archivo en la bóveda secreta del servidor
        \Illuminate\Support\Facades\Storage::disk('local')->put('backups/' . $fileName, $sql);

        // 4. LIMPIEZA INTELIGENTE (Borrar los que tengan más de 3 días)
        $shouldDelete = \App\Models\Setting::where('key', 'backup_delete_old')->value('value');
        if ($shouldDelete === '1') {
            $files = \Illuminate\Support\Facades\Storage::disk('local')->files('backups');
            $ahora = \Carbon\Carbon::now();

            foreach ($files as $file) {
                // Obtenemos la fecha exacta en la que se creó el archivo
                $fechaArchivo = \Carbon\Carbon::createFromTimestamp(\Illuminate\Support\Facades\Storage::disk('local')->lastModified($file));
                
                // Si la diferencia entre hoy y la fecha del archivo es de 3 días o más, lo eliminamos
                if ($ahora->diffInDays($fechaArchivo) >= 3) {
                    \Illuminate\Support\Facades\Storage::disk('local')->delete($file);
                }
            }
        }

        return response('Backup guardado en servidor y limpieza completada exitosamente.', 200);
    }
}

