<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationAdminController extends Controller
{
    // Carga la vista de administración con los datos
    public function index()
    {
        $reservations = Reservation::orderBy('fecha_reservacion', 'desc')
                        ->orderBy('hora_reservacion', 'desc')
                        ->paginate(10);

        return view('admin.reservaciones', compact('reservations'));
    }

    // Maneja el cambio de estado (Confirmar/Cancelar)
    public function updateStatus(Reservation $reservation, $status)
    {
        $validStatuses = ['pending', 'confirmed', 'cancelled'];

        if (in_array($status, $validStatuses)) {
            $reservation->update(['status' => $status]);
            return back()->with('success', 'Reserva actualizada a ' . $status);
        }

        return back()->with('error', 'Estado no válido.');
    }
}
