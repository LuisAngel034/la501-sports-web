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

        // Leer todos los archivos de la bóveda secreta
        $files = \Illuminate\Support\Facades\Storage::disk('local')->files('backups');
        $backups = [];
        
        foreach ($files as $file) {
            // 1. Obtenemos el "timestamp" crudo (los segundos transcurridos desde 1970)
            $timestamp = \Illuminate\Support\Facades\Storage::disk('local')->lastModified($file);
            
            // 2. Creamos un objeto Carbon a partir de ese timestamp y FORZAMOS que se traduzca a la hora de México
            $carbonDate = \Carbon\Carbon::createFromTimestamp($timestamp)->setTimezone('America/Mexico_City');

            $backups[] = [
                'name' => basename($file),
                'path' => $file,
                'size' => round(\Illuminate\Support\Facades\Storage::disk('local')->size($file) / 1024, 2) . ' KB',
                // Pasamos el string de la fecha ya formateado con la hora correcta
                'date' => $carbonDate->format('Y-m-d H:i:s')
            ];
        }
        
        // Ordenamos el arreglo para que el respaldo más nuevo salga hasta arriba
        usort($backups, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        // Limitar la lista a solo los 3 primeros (los más recientes)
        $backups = array_slice($backups, 0, 3);

        return view('admin.database', compact('backups'));
    }

    // =====================================================================
    // 1. MOTOR PRINCIPAL DE SQL (Lo usan tanto el manual como el automático)
    // =====================================================================
    private function generarSQLCompleto()
    {
        $sql = "-- ========================================================\n";
        $sql .= "-- RESPALDO COMPLETO DE BASE DE DATOS: La 501 Sports\n";
        $sql .= "-- Fecha de generación: " . now('America/Mexico_City')->format('Y-m-d H:i:s') . "\n";
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

        $sql = $this->generarSQLCompleto(); 
        // Usamos now con zona horaria en lugar de date()
        $fileName = 'backup_manual_la501_' . now('America/Mexico_City')->format('Y-m-d_H-i-s') . '.sql';

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
        // 1. Revisar si el interruptor general está encendido
        $isEnabled = \App\Models\Setting::where('key', 'backup_enabled')->value('value');
        if ($isEnabled !== '1') {
            return response('El respaldo automático está apagado en el panel.', 200);
        }

        // 2. Leer las reglas que configuraste en tu panel
        $frecuencia = \App\Models\Setting::where('key', 'backup_frecuencia')->value('value') ?? 'diario';
        $horaDeseada = \App\Models\Setting::where('key', 'backup_hora')->value('value') ?? '03:00';
        $intervalo = \App\Models\Setting::where('key', 'backup_intervalo')->value('value') ?? '60';
        
        // Ver cuándo fue la última vez que este robot hizo un respaldo exitoso
        $lastRun = \App\Models\Setting::where('key', 'backup_last_run')->value('value');
        
        $ahora = now('America/Mexico_City');
        $debeEjecutarse = false;

        // 3. EL CEREBRO: Decidir si ya es hora o no
        if (!$lastRun) {
            $debeEjecutarse = true; // Si nunca en la vida se ha ejecutado, que lo haga ya
        } else {
            $ultimaVez = \Carbon\Carbon::parse($lastRun, 'America/Mexico_City');

            if ($frecuencia === 'intervalo') {
                // Si pasaron los minutos que elegiste (ej. 15, 30, 60)
                if ($ahora->diffInMinutes($ultimaVez) >= (int)$intervalo) {
                    $debeEjecutarse = true;
                }
            } elseif ($frecuencia === 'diario') {
                // Si es un día diferente al último respaldo, y el reloj ya pasó la hora que elegiste
                if (!$ahora->isSameDay($ultimaVez) && $ahora->format('H:i') >= $horaDeseada) {
                    $debeEjecutarse = true;
                }
            } elseif ($frecuencia === 'semanal') {
                if ($ahora->diffInDays($ultimaVez) >= 7 && $ahora->format('H:i') >= $horaDeseada) {
                    $debeEjecutarse = true;
                }
            } elseif ($frecuencia === 'mensual') {
                if ($ahora->diffInMonths($ultimaVez) >= 1 && $ahora->format('H:i') >= $horaDeseada) {
                    $debeEjecutarse = true;
                }
            }
        }

        // Si el cadenero dice que no es hora, cancelamos todo silenciosamente
        if (!$debeEjecutarse) {
            return response('Hostinger visitó la URL, pero aún no es momento según las reglas del panel.', 200);
        }

        // 4. Registrar en la base de datos que "Ahorita" se está ejecutando
        \App\Models\Setting::updateOrCreate(
            ['key' => 'backup_last_run'], 
            ['value' => $ahora->format('Y-m-d H:i:s')]
        );

        // 5. Generar el archivo SQL
        $sql = $this->generarSQLCompleto();
        $fileName = 'autobackup_' . $ahora->format('Y-m-d_H-i-s') . '.sql';

        // 6. Guardar el archivo en la bóveda secreta
        \Illuminate\Support\Facades\Storage::disk('local')->put('backups/' . $fileName, $sql);

        // 7. LIMPIEZA INTELIGENTE (Borrar los que tengan más de 3 días)
        $shouldDelete = \App\Models\Setting::where('key', 'backup_delete_old')->value('value');
        if ($shouldDelete === '1') {
            $files = \Illuminate\Support\Facades\Storage::disk('local')->files('backups');
            foreach ($files as $file) {
                $fechaArchivo = \Carbon\Carbon::createFromTimestamp(\Illuminate\Support\Facades\Storage::disk('local')->lastModified($file))
                                ->timezone('America/Mexico_City');
                
                if ($ahora->diffInDays($fechaArchivo) >= 3) {
                    \Illuminate\Support\Facades\Storage::disk('local')->delete($file);
                }
            }
        }

        return response('Backup guardado en servidor y limpieza completada exitosamente.', 200);
    }

    // =====================================================================
    // 5. RESTAURAR DESDE EL HISTORIAL DEL SERVIDOR
    // =====================================================================
    public function restore(\Illuminate\Http\Request $request)
    {
        $userId = \Illuminate\Support\Facades\Auth::id(); // 1. Guardamos tu ID actual
        if ($userId !== 2) return back()->with('error', 'Denegado.');

        $path = $request->file_path;
        
        if (!\Illuminate\Support\Facades\Storage::disk('local')->exists($path)) {
            return back()->with('error', 'El archivo de respaldo no fue encontrado.');
        }

        $sql = \Illuminate\Support\Facades\Storage::disk('local')->get($path);
        
        try {
            $sql = str_replace(['DELIMITER $$', 'DELIMITER ;', '$$'], '', $sql);
            
            DB::unprepared($sql); // 2. Destruimos y reconstruimos el mundo
            
            \Illuminate\Support\Facades\Auth::loginUsingId($userId); // 3. Te volvemos a loguear mágicamente
            
            return back()->with('success', '¡Base de datos restaurada con éxito desde el historial automático!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error crítico al restaurar: ' . $e->getMessage());
        }
    }

    // =====================================================================
    // 6. RESTAURAR DESDE UN ARCHIVO SUBIDO MANUALMENTE
    // =====================================================================
    public function restoreUpload(\Illuminate\Http\Request $request)
    {
        $userId = \Illuminate\Support\Facades\Auth::id(); // 1. Guardamos tu ID
        if ($userId !== 2) return back()->with('error', 'Denegado.');

        if (!$request->hasFile('sql_file')) {
            return back()->with('error', 'Por favor selecciona un archivo .sql');
        }

        $file = $request->file('sql_file');
        
        if (strtolower($file->getClientOriginalExtension()) !== 'sql') {
            return back()->with('error', 'El archivo debe ser un formato .sql válido.');
        }

        $sql = file_get_contents($file->getRealPath());

        try {
            $sql = str_replace(['DELIMITER $$', 'DELIMITER ;', '$$'], '', $sql);
            
            DB::unprepared($sql);
            
            \Illuminate\Support\Facades\Auth::loginUsingId($userId);
            
            return back()->with('success', '¡Base de datos restaurada exitosamente con tu archivo manual!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error crítico al restaurar: ' . $e->getMessage());
        }
    }

    // =====================================================================
    // 7. HISTORIAL COMPLETO Y FILTROS
    // =====================================================================
    public function databaseHistory(\Illuminate\Http\Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::id() !== 2) return redirect()->route('admin.dashboard')->with('error', 'Denegado.');

        // 1. Obtener lo que el usuario está buscando (si aplicó filtros)
        $fechaFiltro = $request->input('fecha'); // Ej: 2026-03-12
        $horaFiltro = $request->input('hora');   // Ej: 14:30

        $files = \Illuminate\Support\Facades\Storage::disk('local')->files('backups');
        $backups = [];
        
        foreach ($files as $file) {
            // CORRECCIÓN: Obtenemos el timestamp crudo y forzamos la zona horaria directamente
            $timestamp = \Illuminate\Support\Facades\Storage::disk('local')->lastModified($file);
            $carbonDate = \Carbon\Carbon::createFromTimestamp($timestamp)->setTimezone('America/Mexico_City');
            
            // Extraemos la fecha y la hora del archivo para compararlas
            $dateString = $carbonDate->format('Y-m-d');
            $horaArchivo = $carbonDate->format('H'); // Ej: '14'

            // Aplicamos Filtro de Fecha (Si el usuario eligió una, y no coincide, saltamos este archivo)
            if ($fechaFiltro && $dateString !== $fechaFiltro) continue;
            
            // Aplicamos Filtro de Hora (Si el usuario eligió 14:30, comparamos que el archivo sea de las 14 hrs)
            if ($horaFiltro) {
                $horaSeleccionada = substr($horaFiltro, 0, 2); 
                if ($horaSeleccionada !== $horaArchivo) continue;
            }

            $backups[] = [
                'name' => basename($file),
                'path' => $file,
                'size' => round(\Illuminate\Support\Facades\Storage::disk('local')->size($file) / 1024, 2) . ' KB',
                'date' => $carbonDate->format('Y-m-d H:i:s'),
                'carbon' => $carbonDate
            ];
        }
        
        // Ordenamos SIEMPRE del más reciente al más antiguo
        usort($backups, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        return view('admin.database-history', compact('backups', 'fechaFiltro', 'horaFiltro'));
    }
}

