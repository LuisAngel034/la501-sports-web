<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Setting;

class ReservationController extends Controller
{

    public function index()
    {
        // Obtenemos las reservaciones ordenadas por las más recientes
        $reservations = \App\Models\Reservation::orderBy('fecha_reservacion', 'desc')
                        ->orderBy('hora_reservacion', 'desc')
                        ->paginate(10);

        return view('admin.reservations.index', compact('reservations'));
    }
    public function store(Request $request)
    {

        $opening = \App\Models\Setting::where('key', 'opening_time')->value('value') ?? '13:00';
        $closing = \App\Models\Setting::where('key', 'closing_time')->value('value') ?? '22:30';

        $request->validate([
            'nombre_completo'    => 'required|string|max:255',
            'telefono'           => 'required|string',
            'correo_electronico' => 'required|email',
            'fecha_reservacion'  => 'required|date|after_or_equal:today',
            'hora_reservacion'   => [
                'required',
                function ($attribute, $value, $fail) use ($opening, $closing) {
                    unset($attribute);
                    
                    $time = strtotime($value);
                    $open = strtotime($opening);
                    $close = strtotime($closing);

                    if ($time < $open || $time > $close) {
                        $fail("Nuestro horario de atención es de {$opening} a {$closing}. Por favor, elige una hora válida.");
                    }
                },
            ],
            'cantidad_personas'  => 'required|integer|max:10',
            'zona'               => 'required|string',
        ]);

        \App\Models\Reservation::create($request->all());

        return back()->with('success', 'Solicitud enviada. Espera nuestra confirmación.');
    }

    public function updateStatus(Reservation $reservation, $status)
    {
        // Validamos que el status sea uno de los permitidos
        if (in_array($status, ['pending', 'confirmed', 'cancelled'])) {
            $reservation->update(['status' => $status]);
            return back()->with('success', 'Estado de la reserva actualizado a: ' . ucfirst($status));
        }

        return back()->with('error', 'Estado no válido.');
    }
}
