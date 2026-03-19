<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
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
}
