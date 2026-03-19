<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // =====================================================================
    // 1. DASHBOARD Y ESTADÍSTICAS
    // =====================================================================
    public function index()
    {
        $recentOrders = \App\Models\Order::with('items')->latest()->take(10)->get();

        $stats = [
            'total_ventas'  => \App\Models\Order::sum('total'),
            'pedidos_hoy'   => \App\Models\Order::whereDate('created_at', today())->count(),
            'reservaciones' => 0,
            'en_proceso'    => \App\Models\Order::where('status', 'pending')->count(),
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

        if ($period == 'day') {
            $sales = \App\Models\Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy('date')->orderBy('date')->get();
            foreach ($sales as $s) {
                $labels[] = date('d M', strtotime($s->date));
                $data[]   = $s->total;
            }
        } elseif ($period == 'month') {
            $sales = \App\Models\Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')->orderBy('month')->get();
            $monthNames = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            foreach ($sales as $s) {
                $labels[] = $monthNames[$s->month];
                $data[]   = $s->total;
            }
        } else {
            $sales = \App\Models\Order::selectRaw('YEAR(created_at) as year, SUM(total) as total')
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
        $mensajes = \App\Models\ContactMessage::orderByRaw("FIELD(status, 'pendiente', 'respondido')")
            ->orderBy('created_at', 'desc')->get();
        return view('admin.mensajes', compact('mensajes'));
    }

    public function marcarRespondido($id)
    {
        $mensaje = \App\Models\ContactMessage::findOrFail($id);
        $mensaje->status = 'respondido';
        $mensaje->save();
        return back()->with('success', 'Mensaje marcado como respondido.');
    }

    // =====================================================================
    // 3. VISTAS DEL SISTEMA DE BASE DE DATOS
    // =====================================================================
    public function database()
    {
        if (\Illuminate\Support\Facades\Auth::id() !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'No tienes permisos para acceder a esta área.');
        }

        $files = \Illuminate\Support\Facades\Storage::disk('local')->files('backups');
        $backups = [];
        
        foreach ($files as $file) {
            $timestamp = \Illuminate\Support\Facades\Storage::disk('local')->lastModified($file);
            $carbonDate = \Carbon\Carbon::createFromTimestamp($timestamp)->setTimezone('America/Mexico_City');

            $backups[] = [
                'name' => basename($file),
                'path' => $file,
                'size' => round(\Illuminate\Support\Facades\Storage::disk('local')->size($file) / 1024, 2) . ' KB',
                'date' => $carbonDate->format('Y-m-d H:i:s')
            ];
        }
        
        usort($backups, function ($a, $b) { return $b['date'] <=> $a['date']; });
        $backups = array_slice($backups, 0, 3);

        return view('admin.database', compact('backups'));
    }

    public function databaseHistory(\Illuminate\Http\Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::id() !== 2) return redirect()->route('admin.dashboard')->with('error', 'Denegado.');

        $fechaFiltro = $request->input('fecha');
        $horaFiltro = $request->input('hora');

        $files = \Illuminate\Support\Facades\Storage::disk('local')->files('backups');
        $backups = [];
        
        foreach ($files as $file) {
            $timestamp = \Illuminate\Support\Facades\Storage::disk('local')->lastModified($file);
            $carbonDate = \Carbon\Carbon::createFromTimestamp($timestamp)->setTimezone('America/Mexico_City');
            
            $dateString = $carbonDate->format('Y-m-d');
            $horaArchivo = $carbonDate->format('H');

            if ($fechaFiltro && $dateString !== $fechaFiltro) continue;
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
        
        usort($backups, function ($a, $b) { return $b['date'] <=> $a['date']; });

        return view('admin.database-history', compact('backups', 'fechaFiltro', 'horaFiltro'));
    }

    // =====================================================================
    // 4. MOTOR PRINCIPAL DE SQL Y RESPALDO MANUAL
    // =====================================================================
    private function generarSQLCompleto()
    {
        $sql = "-- ========================================================\n";
        $sql .= "-- RESPALDO COMPLETO DE BASE DE DATOS: La 501 Sports\n";
        $sql .= "-- Fecha de generación: " . now('America/Mexico_City')->format('Y-m-d H:i:s') . "\n";
        $sql .= "-- ========================================================\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sql .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n\n";

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

    public function createBackup(Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::id() !== 2) return redirect()->route('admin.dashboard')->with('error', 'Denegado.');

        $sql = $this->generarSQLCompleto(); 
        $ahora = now('America/Mexico_City');
        $fileName = 'manual_backup_' . $ahora->format('Y-m-d_H-i-s') . '.sql';
        $path = 'backups/' . $fileName;

        \Illuminate\Support\Facades\Storage::disk('local')->put($path, $sql);

        return back()->with([
            'success' => '¡Respaldo generado y guardado con éxito!',
            'download_path' => $path,
            'file_name' => $fileName
        ]);
    }

    public function downloadBackup(Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::id() !== 2) return back()->with('error', 'Denegado.');

        $path = $request->file_path;
        if (!\Illuminate\Support\Facades\Storage::disk('local')->exists($path)) {
            return back()->with('error', 'El archivo ya no existe en el servidor.');
        }

        return \Illuminate\Support\Facades\Storage::disk('local')->download($path);
    }

    // =====================================================================
    // 5. RESTAURACIÓN DE DATOS
    // =====================================================================
    public function restore(\Illuminate\Http\Request $request)
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        if ($userId !== 2) return back()->with('error', 'Denegado.');

        $path = $request->file_path;
        if (!\Illuminate\Support\Facades\Storage::disk('local')->exists($path)) return back()->with('error', 'El archivo de respaldo no fue encontrado.');

        $sql = \Illuminate\Support\Facades\Storage::disk('local')->get($path);
        
        try {
            $sql = str_replace(['DELIMITER $$', 'DELIMITER ;', '$$'], '', $sql);
            DB::unprepared($sql);
            \Illuminate\Support\Facades\Auth::loginUsingId($userId);
            return back()->with('success', '¡Base de datos restaurada con éxito desde el historial!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error crítico al restaurar: ' . $e->getMessage());
        }
    }

    public function restoreUpload(\Illuminate\Http\Request $request)
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        if ($userId !== 2) return back()->with('error', 'Denegado.');

        if (!$request->hasFile('sql_file')) return back()->with('error', 'Por favor selecciona un archivo .sql');

        $file = $request->file('sql_file');
        if (strtolower($file->getClientOriginalExtension()) !== 'sql') return back()->with('error', 'El archivo debe ser un formato .sql válido.');

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
    // 6. CONFIGURACIÓN Y MOTOR DE AUTOMATIZACIÓN
    // =====================================================================
    public function saveAuto(\Illuminate\Http\Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::id() !== 2) return redirect()->route('admin.dashboard')->with('error', 'Denegado.');

        $enabled = $request->input('backup_enabled', '0');
        
        \App\Models\Setting::updateOrCreate(['key' => 'backup_enabled'], ['value' => $enabled]);
        
        if ($enabled == '1') {
            \App\Models\Setting::updateOrCreate(['key' => 'backup_frecuencia'], ['value' => $request->frecuencia]);
            \App\Models\Setting::updateOrCreate(['key' => 'backup_hora'], ['value' => $request->hora ?? '03:00']);
            \App\Models\Setting::updateOrCreate(['key' => 'backup_intervalo'], ['value' => $request->intervalo ?? '60']);
            \App\Models\Setting::updateOrCreate(['key' => 'backup_delete_old'], ['value' => '1']);
        }

        return back()->with('success', 'Configuración de automatización actualizada.');
    }

    public function runAutoBackup(\Illuminate\Http\Request $request)
    {
        $isEnabled = \App\Models\Setting::where('key', 'backup_enabled')->orderBy('id', 'desc')->value('value');
        if ($isEnabled !== '1') {
            return response('Apagado.', 200)->header('Cache-Control', 'no-store, no-cache');
        }

        $frecuencia = \App\Models\Setting::where('key', 'backup_frecuencia')->orderBy('id', 'desc')->value('value') ?? 'diario';
        $intervalo = \App\Models\Setting::where('key', 'backup_intervalo')->orderBy('id', 'desc')->value('value') ?? '60';
        $horaDeseada = \App\Models\Setting::where('key', 'backup_hora')->orderBy('id', 'desc')->value('value') ?? '03:00';
        $lastRun = \App\Models\Setting::where('key', 'backup_last_run')->orderBy('id', 'desc')->value('value');
        
        $ahora = now('America/Mexico_City');
        $debeEjecutarse = false;
        $mensajeDiagnostico = "";

        if (!$lastRun) {
            $debeEjecutarse = true;
        } else {
            $tiempoUltimaVez = strtotime($lastRun);
            $tiempoAhora = strtotime($ahora->format('Y-m-d H:i:s'));
            
            if ($frecuencia === 'intervalo') {
                $segundosPasados = $tiempoAhora - $tiempoUltimaVez;
                $segundosRequeridos = ((int)$intervalo * 60) - 10; 
                
                if ($segundosPasados >= $segundosRequeridos) {
                    $debeEjecutarse = true;
                } else {
                    $faltan = $segundosRequeridos - $segundosPasados;
                    $mensajeDiagnostico = "⏳ DIAGNÓSTICO (Intervalo {$intervalo}m): Han pasado {$segundosPasados}s. Faltan {$faltan}s.";
                }
            } else {
                $ultimaVezCarbon = \Carbon\Carbon::parse($lastRun, 'America/Mexico_City');
                $horaActualStr = $ahora->format('H:i');
                
                if ($frecuencia === 'diario') {
                    if (!$ahora->isSameDay($ultimaVezCarbon) && $horaActualStr >= $horaDeseada) {
                        $debeEjecutarse = true;
                    } else {
                        $mensajeDiagnostico = "⏳ DIAGNÓSTICO: Aún no se cumple el día y la hora.";
                    }
                } elseif ($frecuencia === 'semanal') {
                    if ($ahora->diffInDays($ultimaVezCarbon) >= 7 && $horaActualStr >= $horaDeseada) {
                        $debeEjecutarse = true;
                    } else {
                        $mensajeDiagnostico = "⏳ DIAGNÓSTICO: Faltan días para el semanal.";
                    }
                } elseif ($frecuencia === 'mensual') {
                    if ($ahora->diffInMonths($ultimaVezCarbon) >= 1 && $horaActualStr >= $horaDeseada) {
                        $debeEjecutarse = true;
                    } else {
                        $mensajeDiagnostico = "⏳ DIAGNÓSTICO: Aún no ha pasado un mes.";
                    }
                }
            }
        }

        if (!$debeEjecutarse) {
            return response($mensajeDiagnostico, 200)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        \App\Models\Setting::where('key', 'backup_last_run')->delete(); 
        \App\Models\Setting::create([
            'key' => 'backup_last_run',
            'value' => $ahora->format('Y-m-d H:i:s')
        ]);

        $sql = $this->generarSQLCompleto();
        $fileName = 'autobackup_' . $ahora->format('Y-m-d_H-i-s') . '.sql';
        \Illuminate\Support\Facades\Storage::disk('local')->put('backups/' . $fileName, $sql);

        $shouldDelete = \App\Models\Setting::where('key', 'backup_delete_old')->orderBy('id', 'desc')->value('value');
        if ($shouldDelete === '1') {
            $files = \Illuminate\Support\Facades\Storage::disk('local')->files('backups');
            foreach ($files as $file) {
                $fechaArchivo = \Carbon\Carbon::createFromTimestamp(\Illuminate\Support\Facades\Storage::disk('local')->lastModified($file))->timezone('America/Mexico_City');
                if ($ahora->diffInDays($fechaArchivo) >= 3) {
                    \Illuminate\Support\Facades\Storage::disk('local')->delete($file);
                }
            }
        }

        return response("✅ CANDADO DESTRUIDO AUTOMÁTICAMENTE Y BACKUP GENERADO.", 200)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    // =====================================================================
    // 7. MONITOR DE RENDIMIENTO DE LA BASE DE DATOS
    // =====================================================================
    public function monitor()
    {
        if (\Illuminate\Support\Facades\Auth::id() !== 2) return redirect()->route('admin.dashboard')->with('error', 'Denegado.');

        $dbName = env('DB_DATABASE');
        $sizeQuery = DB::select("SELECT SUM(data_length + index_length) / 1024 / 1024 AS size FROM information_schema.TABLES WHERE table_schema = ?", [$dbName]);
        $dbSize = round($sizeQuery[0]->size ?? 0, 2);

        $status = DB::select("SHOW GLOBAL STATUS");
        $metrics = [];
        foreach($status as $s) {
            $metrics[$s->Variable_name] = $s->Value;
        }

        $vars = DB::select("SHOW GLOBAL VARIABLES");
        $variables = [];
        foreach($vars as $v) {
            $variables[$v->Variable_name] = $v->Value;
        }

        $uptime = $metrics['Uptime'] ?? 0;
        $queries = $metrics['Queries'] ?? 0;
        $qps = $uptime > 0 ? round($queries / $uptime, 2) : 0;
        
        $connections = $metrics['Threads_connected'] ?? 0;
        $maxConnections = $variables['max_connections'] ?? 0;
        $slowQueries = $metrics['Slow_queries'] ?? 0;
        
        $days = floor($uptime / 86400);
        $hours = floor(($uptime % 86400) / 3600);
        $uptimeStr = "{$days} días, {$hours} hrs";

        $version = DB::select("SELECT VERSION() as version")[0]->version;

        return view('admin.database-monitor', compact(
            'dbSize', 'uptimeStr', 'qps', 'connections', 'maxConnections', 'slowQueries', 'version'
        ));
    }
}
