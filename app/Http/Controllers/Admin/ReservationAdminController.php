<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationAdminController extends Controller
{
    public function index(Request $request)
    {
        // 1. Usamos 'pendiente' como valor por defecto para que coincida con la DB
        $status = $request->get('status', 'pendiente');

        $reservations = Reservation::where('status', $status)
                        ->orderBy('fecha_reservacion', 'asc')
                        ->orderBy('hora_reservacion', 'asc')
                        ->paginate(10)
                        ->withQueryString();

        return view('admin.reservaciones', compact('reservations'));
    }

    public function updateStatus(Reservation $reservation, $status)
    {
        // 2. Validamos contra los estados reales de tu ENUM en la DB
        $validStatuses = ['pendiente', 'confirmada', 'cancelada'];

        if (in_array($status, $validStatuses)) {
            $reservation->update(['status' => $status]);
            return back()->with('success', 'Reserva actualizada correctamente.');
        }

        return back()->with('error', 'Estado no válido.');
    }
}
