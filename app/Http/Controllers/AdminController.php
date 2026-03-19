<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Constantes para evitar literales duplicados (SonarQube S1192)
    private const TZ_MEXICO         = 'America/Mexico_City';
    private const FORMAT_DATETIME   = 'Y-m-d H:i:s';
    private const BACKUP_DISK       = 'local';
    private const BACKUP_DIR        = 'backups';

    // =========================================================================
    // Dashboard y vistas generales
    // =========================================================================

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
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            foreach ($sales as $s) {
                $labels[] = date('d M', strtotime($s->date));
                $data[]   = $s->total;
            }
        } elseif ($period == 'month') {
            $sales = \App\Models\Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
            $monthNames = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            foreach ($sales as $s) {
                $labels[] = $monthNames[$s->month];
                $data[]   = $s->total;
            }
        } else {
            $sales = \App\Models\Order::selectRaw('YEAR(created_at) as year, SUM(total) as total')
                ->groupBy('year')
                ->orderBy('year')
                ->get();
            foreach ($sales as $s) {
                $labels[] = $s->year;
                $data[]   = $s->total;
            }
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    public function mensajes()
    {
        $mensajes = \App\Models\ContactMessage::orderByRaw("FIELD(status, 'pendiente', 'respondido')")
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.mensajes', compact('mensajes'));
    }

    public function marcarRespondido($id)
    {
        $mensaje = \App\Models\ContactMessage::findOrFail($id);
        $mensaje->status = 'respondido';
        $mensaje->save();
        return back()->with('success', 'Mensaje marcado como respondido.');
    }

    // =========================================================================
    // Base de datos / Backups
    // =========================================================================

    public function database()
    {
        if (Auth::id() !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'No tienes permisos para acceder a esta área.');
        }

        $backups = $this->listarBackups(3);

        return view('admin.database', compact('backups'));
    }

    // -------------------------------------------------------------------------
    // Generación de SQL — Refactorizado para bajar Cognitive Complexity 21 → ~8
    // La lógica de exportar filas se extrajo a buildTableRows().
    // -------------------------------------------------------------------------

    private function generarSQLCompleto(): string
    {
        $ahora = now(self::TZ_MEXICO)->format(self::FORMAT_DATETIME);

        $sql  = "-- ========================================================\n";
        $sql .= "-- RESPALDO COMPLETO DE BASE DE DATOS: La 501 Sports\n";
        $sql .= "-- Fecha de generación: {$ahora}\n";
        $sql .= "-- ========================================================\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sql .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n\n";

        $tables = DB::select('SHOW FULL TABLES');

        foreach ($tables as $table) {
            $tableArray = array_values((array) $table);
            $tableName  = $tableArray[0];
            $tableType  = $tableArray[1];

            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= "DROP VIEW IF EXISTS `{$tableName}`;\n";

            $sql .= $this->buildTableStructure($tableName, $tableType);
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        return $sql;
    }

    private function buildTableStructure(string $tableName, string $tableType): string
    {
        $sql = '';

        try {
            if ($tableType === 'VIEW') {
                $createTable = DB::select("SHOW CREATE VIEW `{$tableName}`");
            } else {
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            }

            $createSql      = array_values((array) $createTable[0]);
            $estructuraLimpia = str_replace('utf8mb4_uca1400_ai_ci', 'utf8mb4_general_ci', $createSql[1]);
            $sql .= $estructuraLimpia . ";\n\n";

            if ($tableType === 'BASE TABLE') {
                $sql .= $this->buildTableRows($tableName);
            }
        } catch (\Exception $e) {
            $sql .= "-- ERROR EN `{$tableName}`: " . $e->getMessage() . "\n\n";
        }

        return $sql;
    }

    private function buildTableRows(string $tableName): string
    {
        $sql  = '';
        $rows = DB::select("SELECT * FROM `{$tableName}`");

        if (count($rows) === 0) {
            return $sql;
        }

        foreach ($rows as $row) {
            $rowArray = (array) $row;
            $values   = array_map(function ($value) {
                if (is_null($value)) {
                    return 'NULL';
                }
                return "'" . str_replace("\n", "\\n", addslashes($value)) . "'";
            }, $rowArray);
            $sql .= "INSERT INTO `{$tableName}` VALUES (" . implode(", ", $values) . ");\n";
        }

        $sql .= "\n\n";

        return $sql;
    }

    // -------------------------------------------------------------------------
    // CRUD de backups
    // -------------------------------------------------------------------------

    public function createBackup(Request $request)
    {
        if (Auth::id() !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'Denegado.');
        }

        $sql      = $this->generarSQLCompleto();
        $ahora    = now(self::TZ_MEXICO);
        $fileName = 'manual_backup_' . $ahora->format('Y-m-d_H-i-s') . '.sql';
        $path     = self::BACKUP_DIR . '/' . $fileName;

        Storage::disk(self::BACKUP_DISK)->put($path, $sql);

        return back()->with([
            'success'       => '¡Respaldo generado y guardado con éxito!',
            'download_path' => $path,
            'file_name'     => $fileName,
        ]);
    }

    public function saveAuto(Request $request)
    {
        if (Auth::id() !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'Denegado.');
        }

        $enabled = $request->input('backup_enabled', '0');

        \App\Models\Setting::updateOrCreate(['key' => 'backup_enabled'], ['value' => $enabled]);

        if ($enabled == '1') {
            \App\Models\Setting::updateOrCreate(['key' => 'backup_frecuencia'], ['value' => $request->frecuencia]);
            \App\Models\Setting::updateOrCreate(['key' => 'backup_hora'],       ['value' => $request->hora ?? '03:00']);
            \App\Models\Setting::updateOrCreate(['key' => 'backup_intervalo'],  ['value' => $request->intervalo ?? '60']);
            \App\Models\Setting::updateOrCreate(['key' => 'backup_delete_old'], ['value' => '1']);
        }

        return back()->with('success', 'Configuración de automatización actualizada.');
    }

    // =========================================================================
    // Motor automático de backups
    // Refactorizado para bajar Cognitive Complexity 40 → ~12
    // La lógica de decisión por frecuencia se extrajo a shouldRunBackup().
    // =========================================================================

    public function runAutoBackup(Request $request)
    {
        $isEnabled = \App\Models\Setting::where('key', 'backup_enabled')->orderBy('id', 'desc')->value('value');
        if ($isEnabled !== '1') {
            return response('Apagado.', 200)->header('Cache-Control', 'no-store, no-cache');
        }

        $frecuencia  = \App\Models\Setting::where('key', 'backup_frecuencia')->orderBy('id', 'desc')->value('value') ?? 'diario';
        $intervalo   = \App\Models\Setting::where('key', 'backup_intervalo')->orderBy('id', 'desc')->value('value') ?? '60';
        $horaDeseada = \App\Models\Setting::where('key', 'backup_hora')->orderBy('id', 'desc')->value('value') ?? '03:00';
        $lastRun     = \App\Models\Setting::where('key', 'backup_last_run')->orderBy('id', 'desc')->value('value');

        $ahora = now(self::TZ_MEXICO);

        [$debeEjecutarse, $mensajeDiagnostico] = $this->shouldRunBackup(
            $frecuencia, $intervalo, $horaDeseada, $lastRun, $ahora
        );

        if (!$debeEjecutarse) {
            return response($mensajeDiagnostico, 200)
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        \App\Models\Setting::where('key', 'backup_last_run')->delete();
        \App\Models\Setting::create([
            'key'   => 'backup_last_run',
            'value' => $ahora->format(self::FORMAT_DATETIME),
        ]);

        $sql      = $this->generarSQLCompleto();
        $fileName = 'autobackup_' . $ahora->format('Y-m-d_H-i-s') . '.sql';
        Storage::disk(self::BACKUP_DISK)->put(self::BACKUP_DIR . '/' . $fileName, $sql);

        $this->eliminarBackupsAntiguos($ahora);

        return response("✅ CANDADO DESTRUIDO AUTOMÁTICAMENTE Y BACKUP GENERADO ({$frecuencia}).", 200)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    private function shouldRunBackup(string $frecuencia, string $intervalo, string $horaDeseada, ?string $lastRun, Carbon $ahora): array
    {
        if (!$lastRun) {
            return [true, ''];
        }

        if ($frecuencia === 'intervalo') {
            return $this->checkIntervalo($intervalo, $lastRun, $ahora);
        }

        return $this->checkPeriodico($frecuencia, $horaDeseada, $lastRun, $ahora);
    }

    private function checkIntervalo(string $intervalo, string $lastRun, Carbon $ahora): array
    {
        $segundosPasados  = strtotime($ahora->format(self::FORMAT_DATETIME)) - strtotime($lastRun);
        $segundosRequeridos = ((int) $intervalo * 60) - 10;

        if ($segundosPasados >= $segundosRequeridos) {
            return [true, ''];
        }

        $faltan = $segundosRequeridos - $segundosPasados;
        return [false, "⏳ DIAGNÓSTICO (Intervalo {$intervalo}m): Han pasado {$segundosPasados}s. Faltan {$faltan}s."];
    }

    private function checkPeriodico(string $frecuencia, string $horaDeseada, string $lastRun, Carbon $ahora): array
    {
        $ultimaVezCarbon = Carbon::parse($lastRun, self::TZ_MEXICO);
        $horaActualStr   = $ahora->format('H:i');

        if ($frecuencia === 'diario') {
            if (!$ahora->isSameDay($ultimaVezCarbon) && $horaActualStr >= $horaDeseada) {
                return [true, ''];
            }
            return [false, "⏳ DIAGNÓSTICO (Diario a las {$horaDeseada}): Aún no se cumple el día y la hora."];
        }

        if ($frecuencia === 'semanal') {
            if ($ahora->diffInDays($ultimaVezCarbon) >= 7 && $horaActualStr >= $horaDeseada) {
                return [true, ''];
            }
            $dias = $ahora->diffInDays($ultimaVezCarbon);
            return [false, "⏳ DIAGNÓSTICO (Semanal a las {$horaDeseada}): Han pasado {$dias} días."];
        }

        if ($frecuencia === 'mensual') {
            if ($ahora->diffInMonths($ultimaVezCarbon) >= 1 && $horaActualStr >= $horaDeseada) {
                return [true, ''];
            }
            return [false, "⏳ DIAGNÓSTICO (Mensual a las {$horaDeseada}): Aún no ha pasado un mes completo."];
        }

        return [false, "⏳ Frecuencia desconocida: {$frecuencia}"];
    }

    private function eliminarBackupsAntiguos(Carbon $ahora): void
    {
        $shouldDelete = \App\Models\Setting::where('key', 'backup_delete_old')->orderBy('id', 'desc')->value('value');

        if ($shouldDelete !== '1') {
            return;
        }

        $files = Storage::disk(self::BACKUP_DISK)->files(self::BACKUP_DIR);

        foreach ($files as $file) {
            $fechaArchivo = Carbon::createFromTimestamp(
                Storage::disk(self::BACKUP_DISK)->lastModified($file)
            )->timezone(self::TZ_MEXICO);

            if ($ahora->diffInDays($fechaArchivo) >= 3) {
                Storage::disk(self::BACKUP_DISK)->delete($file);
            }
        }
    }

    // =========================================================================
    // Restauración de base de datos
    // =========================================================================

    public function restore(Request $request)
    {
        $userId = Auth::id();
        if ($userId !== 2) {
            return back()->with('error', 'Denegado.');
        }

        $path = $request->file_path;
        if (!Storage::disk(self::BACKUP_DISK)->exists($path)) {
            return back()->with('error', 'El archivo de respaldo no fue encontrado.');
        }

        $sql = Storage::disk(self::BACKUP_DISK)->get($path);

        try {
            $sql = str_replace(['DELIMITER $$', 'DELIMITER ;', '$$'], '', $sql);
            DB::unprepared($sql);
            Auth::loginUsingId($userId);
            return back()->with('success', '¡Base de datos restaurada con éxito desde el historial!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error crítico al restaurar: ' . $e->getMessage());
        }
    }

    public function restoreUpload(Request $request)
    {
        $userId = Auth::id();
        if ($userId !== 2) {
            return back()->with('error', 'Denegado.');
        }

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
            Auth::loginUsingId($userId);
            return back()->with('success', '¡Base de datos restaurada exitosamente con tu archivo manual!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error crítico al restaurar: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // Historial y descarga de backups
    // =========================================================================

    public function databaseHistory(Request $request)
    {
        if (Auth::id() !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'Denegado.');
        }

        $fechaFiltro = $request->input('fecha');
        $horaFiltro  = $request->input('hora');

        $files   = Storage::disk(self::BACKUP_DISK)->files(self::BACKUP_DIR);
        $backups = [];

        foreach ($files as $file) {
            $timestamp   = Storage::disk(self::BACKUP_DISK)->lastModified($file);
            $carbonDate  = Carbon::createFromTimestamp($timestamp)->setTimezone(self::TZ_MEXICO);
            $dateString  = $carbonDate->format('Y-m-d');
            $horaArchivo = $carbonDate->format('H');

            if ($fechaFiltro && $dateString !== $fechaFiltro) {
                continue;
            }

            if ($horaFiltro) {
                $horaSeleccionada = substr($horaFiltro, 0, 2);
                if ($horaSeleccionada !== $horaArchivo) {
                    continue;
                }
            }

            $backups[] = [
                'name'   => basename($file),
                'path'   => $file,
                'size'   => round(Storage::disk(self::BACKUP_DISK)->size($file) / 1024, 2) . ' KB',
                'date'   => $carbonDate->format(self::FORMAT_DATETIME),
                'carbon' => $carbonDate,
            ];
        }

        usort($backups, fn($a, $b) => $b['date'] <=> $a['date']);

        return view('admin.database-history', compact('backups', 'fechaFiltro', 'horaFiltro'));
    }

    public function downloadBackup(Request $request)
    {
        if (Auth::id() !== 2) {
            return back()->with('error', 'Denegado.');
        }

        $path = $request->file_path;
        if (!Storage::disk(self::BACKUP_DISK)->exists($path)) {
            return back()->with('error', 'El archivo ya no existe en el servidor.');
        }

        return Storage::disk(self::BACKUP_DISK)->download($path);
    }

    // =========================================================================
    // Helpers privados
    // =========================================================================

    private function listarBackups(int $limit = 0): array
    {
        $files   = Storage::disk(self::BACKUP_DISK)->files(self::BACKUP_DIR);
        $backups = [];

        foreach ($files as $file) {
            $timestamp  = Storage::disk(self::BACKUP_DISK)->lastModified($file);
            $carbonDate = Carbon::createFromTimestamp($timestamp)->setTimezone(self::TZ_MEXICO);

            $backups[] = [
                'name' => basename($file),
                'path' => $file,
                'size' => round(Storage::disk(self::BACKUP_DISK)->size($file) / 1024, 2) . ' KB',
                'date' => $carbonDate->format(self::FORMAT_DATETIME),
            ];
        }

        usort($backups, fn($a, $b) => $b['date'] <=> $a['date']);

        return $limit > 0 ? array_slice($backups, 0, $limit) : $backups;
    }
}

