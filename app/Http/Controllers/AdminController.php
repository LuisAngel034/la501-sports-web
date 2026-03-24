<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\ContactMessage;
use App\Models\Setting;

class AdminController extends Controller
{
    // Constantes para evitar duplicación de literales (php:S1192)
    private const TIMEZONE = 'America/Mexico_City';
    private const DATE_FORMAT = 'Y-m-d H:i:s';
    private const BACKUP_DISK = 'local';

    // =====================================================================
    // 1. DASHBOARD Y ESTADÍSTICAS
    // =====================================================================
    public function index()
    {
        $recentOrders = Order::with('items')->latest()->take(10)->get();

        $stats = [
            'total_ventas'  => Order::sum('total'),
            'pedidos_hoy'   => Order::whereDate('created_at', today())->count(),
            'reservaciones' => 0,
            'en_proceso'    => Order::where('status', 'pending')->count(),
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
        $data   = [];

        if ($period === 'day') {
            $sales = Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy('date')->orderBy('date')->get();
            foreach ($sales as $s) {
                $labels[] = date('d M', strtotime($s->date));
                $data[]   = $s->total;
            }
        } elseif ($period === 'month') {
            $sales = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')->orderBy('month')->get();
            $monthNames = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            foreach ($sales as $s) {
                $labels[] = $monthNames[$s->month];
                $data[]   = $s->total;
            }
        } else {
            $sales = Order::selectRaw('YEAR(created_at) as year, SUM(total) as total')
                ->groupBy('year')->orderBy('year')->get();
            foreach ($sales as $s) {
                $labels[] = $s->year;
                $data[]   = $s->total;
            }
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    // =====================================================================
    // 2. MENSAJES (CRM)
    // =====================================================================
    public function mensajes()
    {
        $mensajes = ContactMessage::orderByRaw("FIELD(status, 'pendiente', 'respondido')")
            ->orderBy('created_at', 'desc')->get();
        return view('admin.mensajes', compact('mensajes'));
    }

    public function marcarRespondido($id)
    {
        $mensaje = ContactMessage::findOrFail($id);
        $mensaje->status = 'respondido';
        $mensaje->save();
        return back()->with('success', 'Mensaje marcado como respondido.');
    }

    // =====================================================================
    // 3. VISTAS DEL SISTEMA DE BASE DE DATOS
    // =====================================================================
    public function database()
    {
        if (Auth::id() !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'No tienes permisos.');
        }

        $files = Storage::disk(self::BACKUP_DISK)->files('backups');
        $backups = [];
        
        foreach ($files as $file) {
            $timestamp = Storage::disk(self::BACKUP_DISK)->lastModified($file);
            $carbonDate = Carbon::createFromTimestamp($timestamp)->setTimezone(self::TIMEZONE);

            $backups[] = [
                'name' => basename($file),
                'path' => $file,
                'size' => round(Storage::disk(self::BACKUP_DISK)->size($file) / 1024, 2) . ' KB',
                'date' => $carbonDate->format(self::DATE_FORMAT)
            ];
        }
        
        usort($backups, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });
        
        $backups = array_slice($backups, 0, 3);
        return view('admin.database', compact('backups'));
    }

    public function databaseHistory(Request $request)
    {
        if (Auth::id() !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'Denegado.');
        }

        $fechaFiltro = $request->input('fecha');
        $horaFiltro = $request->input('hora');
        $files = Storage::disk(self::BACKUP_DISK)->files('backups');
        $backups = [];
        
        foreach ($files as $file) {
            $timestamp = Storage::disk(self::BACKUP_DISK)->lastModified($file);
            $carbonDate = Carbon::createFromTimestamp($timestamp)->setTimezone(self::TIMEZONE);
            
            if ($fechaFiltro && $carbonDate->format('Y-m-d') !== $fechaFiltro) {
                continue;
            }
            if ($horaFiltro && substr($horaFiltro, 0, 2) !== $carbonDate->format('H')) {
                continue;
            }

            $backups[] = [
                'name' => basename($file),
                'path' => $file,
                'size' => round(Storage::disk(self::BACKUP_DISK)->size($file) / 1024, 2) . ' KB',
                'date' => $carbonDate->format(self::DATE_FORMAT),
                'carbon' => $carbonDate,
            ];
        }
        
        usort($backups, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        return view('admin.database-history', compact('backups', 'fechaFiltro', 'horaFiltro'));
    }

    // =====================================================================
    // 4. MOTOR DE RESPALDO
    // =====================================================================
    private function generarSQLCompleto()
    {
        $sql = "-- RESPALDO: La 501 Sports\n";
        $sql .= "-- Fecha: " . now(self::TIMEZONE)->format(self::DATE_FORMAT) . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";

        $tables = DB::select('SHOW FULL TABLES');
        foreach ($tables as $table) {
            $tableArray = array_values((array)$table);
            $tableName = $tableArray[0];
            $tableType = $tableArray[1];

            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
            
            try {
                $createSqlRes = ($tableType === 'VIEW')
                    ? DB::select("SHOW CREATE VIEW `$tableName`")[0]
                    : DB::select("SHOW CREATE TABLE `$tableName`")[0];
                
                $createSql = array_values((array)$createSqlRes)[1];
                $sql .= str_replace('utf8mb4_uca1400_ai_ci', 'utf8mb4_general_ci', $createSql) . ";\n\n";

                if ($tableType === 'BASE TABLE') {
                    $sql .= $this->getInsertsForTable($tableName);
                }
            } catch (\Exception $e) {
                $sql .= "-- ERROR EN `$tableName`: " . $e->getMessage() . "\n\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        return $sql;
    }

    private function getInsertsForTable($tableName)
    {
        $sql = "";
        $rows = DB::select("SELECT * FROM `$tableName`");
        foreach ($rows as $row) {
            $values = array_map(function ($value) {
                if (is_null($value)) {
                    return 'NULL';
                }
                return "'" . str_replace("\n", "\\n", addslashes($value)) . "'";
            }, (array)$row);
            $sql .= "INSERT INTO `$tableName` VALUES (" . implode(", ", $values) . ");\n";
        }
        return $sql . "\n";
    }

    public function createBackup()
    {
        if (Auth::id() !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'Denegado.');
        }

        $sql = $this->generarSQLCompleto();
        $fileName = 'manual_backup_' . now(self::TIMEZONE)->format('Y-m-d_H-i-s') . '.sql';
        $path = 'backups/' . $fileName;

        Storage::disk(self::BACKUP_DISK)->put($path, $sql);

        return back()->with([
            'success' => '¡Respaldo guardado!',
            'download_path' => $path,
            'file_name' => $fileName
        ]);
    }

    // =====================================================================
    // 5. RESTAURACIÓN Y DESCARGA
    // =====================================================================
    public function downloadBackup(Request $request)
    {
        if (Auth::id() !== 2) {
            return back()->with('error', 'Denegado.');
        }

        if (!Storage::disk(self::BACKUP_DISK)->exists($request->file_path)) {
            return back()->with('error', 'Archivo no encontrado.');
        }

        return Storage::disk(self::BACKUP_DISK)->download($request->file_path);
    }

    public function restore(Request $request)
    {
        $userId = Auth::id();
        $response = back();

        if ($userId !== 2) {
            return $response->with('error', 'Denegado.');
        }

        if (!Storage::disk(self::BACKUP_DISK)->exists($request->file_path)) {
            return $response->with('error', 'Archivo no encontrado.');
        }

        try {
            $sql = Storage::disk(self::BACKUP_DISK)->get($request->file_path);
            DB::unprepared(str_replace(['DELIMITER $$', 'DELIMITER ;', '$$'], '', $sql));
            Auth::loginUsingId($userId);
            $response = $response->with('success', '¡Restaurado con éxito!');
        } catch (\Exception $e) {
            $response = $response->with('error', 'Error: ' . $e->getMessage());
        }

        return $response;
    }

    // =====================================================================
    // 6. AUTOMATIZACIÓN (Refactorizado para bajar Complejidad Cognitiva)
    // =====================================================================
    public function saveAuto(Request $request)
    {
        if (Auth::id() !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'Denegado.');
        }

        $enabled = $request->input('backup_enabled', '0');
        Setting::updateOrCreate(['key' => 'backup_enabled'], ['value' => $enabled]);
        
        if ($enabled === '1') {
            Setting::updateOrCreate(['key' => 'backup_frecuencia'], ['value' => $request->frecuencia]);
            Setting::updateOrCreate(['key' => 'backup_hora'], ['value' => $request->hora ?? '03:00']);
            Setting::updateOrCreate(['key' => 'backup_intervalo'], ['value' => $request->intervalo ?? '60']);
            Setting::updateOrCreate(['key' => 'backup_delete_old'], ['value' => '1']);
        }

        return back()->with('success', 'Configuración actualizada.');
    }

    public function runAutoBackup()
    {
        $isEnabled = Setting::where('key', 'backup_enabled')->value('value');
        if ($isEnabled !== '1') {
            return response('Apagado.', 200);
        }

        $diagnostico = $this->checkSiDebeEjecutarse();
        if ($diagnostico !== true) {
            return response($diagnostico, 200);
        }

        return $this->ejecutarProcesoBackup();
    }

    private function checkSiDebeEjecutarse()
    {
        $lastRun = Setting::where('key', 'backup_last_run')->value('value');

        $ahora      = now(self::TIMEZONE);
        $ultimaVez  = $lastRun ? Carbon::parse($lastRun, self::TIMEZONE) : $ahora->copy()->subYears(10);
        $frecuencia = Setting::where('key', 'backup_frecuencia')->value('value') ?? 'diario';

        if ($frecuencia === 'intervalo') {
            $minutos = (int)(Setting::where('key', 'backup_intervalo')->value('value') ?? '60');
            return ($ahora->diffInMinutes($ultimaVez) >= $minutos) ? true : "⏳ Faltan minutos.";
        }

        $horaDeseada = Setting::where('key', 'backup_hora')->value('value') ?? '03:00';
        if ($ahora->format('H:i') < $horaDeseada) {
            return "⏳ Aún no es la hora.";
        }

        return $this->validarFrecuenciaTemporal($frecuencia, $ahora, $ultimaVez);
    }

    private function ejecutarProcesoBackup()
    {
        $ahora = now(self::TIMEZONE);
        Setting::updateOrCreate(['key' => 'backup_last_run'], ['value' => $ahora->format(self::DATE_FORMAT)]);

        $fileName = 'autobackup_' . $ahora->format('Y-m-d_H-i-s') . '.sql';
        Storage::disk(self::BACKUP_DISK)->put('backups/' . $fileName, $this->generarSQLCompleto());

        if (Setting::where('key', 'backup_delete_old')->value('value') === '1') {
            $this->limpiarOldBackups($ahora);
        }

        return response("✅ BACKUP AUTOMÁTICO GENERADO.", 200);
    }

    private function limpiarOldBackups($ahora)
    {
        $files = Storage::disk(self::BACKUP_DISK)->files('backups');
        foreach ($files as $file) {
            $mTime = Storage::disk(self::BACKUP_DISK)->lastModified($file);
            $fechaFile = Carbon::createFromTimestamp($mTime, self::TIMEZONE);
            if ($ahora->diffInDays($fechaFile) >= 3) {
                Storage::disk(self::BACKUP_DISK)->delete($file);
            }
        }
    }

    // =====================================================================
    // 7. MONITOR
    // =====================================================================
    public function monitor()
    {
        if (Auth::id() !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'Denegado.');
        }

        $dbName = env('DB_DATABASE');
        $sizeQuery = DB::select("SELECT SUM(data_length + index_length) / 1024 / 1024 AS size FROM information_schema.TABLES WHERE table_schema = ?", [$dbName]);
        $dbSize = round($sizeQuery[0]->size ?? 0, 2);

        $metrics = collect(DB::select("SHOW GLOBAL STATUS"))->pluck('Value', 'Variable_name');
        $variables = collect(DB::select("SHOW GLOBAL VARIABLES"))->pluck('Value', 'Variable_name');

        $uptime = $metrics['Uptime'] ?? 0;
        $qps = $uptime > 0 ? round(($metrics['Queries'] ?? 0) / $uptime, 2) : 0;
        
        $uptimeStr = floor($uptime / 86400) . " días, " . floor(($uptime % 86400) / 3600) . " hrs";
        $version = DB::select("SELECT VERSION() as v")[0]->v;

        return view('admin.database-monitor', [
            'dbSize' => $dbSize,
            'uptimeStr' => $uptimeStr,
            'qps' => $qps,
            'connections' => $metrics['Threads_connected'] ?? 0,
            'maxConnections' => $variables['max_connections'] ?? 0,
            'slowQueries' => $metrics['Slow_queries'] ?? 0,
            'version' => $version
        ]);
    }
}
