<?php

namespace App\Http\Controllers\Anfitrion;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;

class AnfitrionReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'hospedaje'])
            ->whereHas('hospedaje', function($query) {
                $query->where('id_anfitrion', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Calcular estadísticas
        $total = Reserva::whereHas('hospedaje', function($query) {
            $query->where('id_anfitrion', Auth::id());
        })->count();

        $pendientes = Reserva::whereHas('hospedaje', function($query) {
            $query->where('id_anfitrion', Auth::id());
        })->where('estado', 'pendiente')->count();

        $confirmadas = Reserva::whereHas('hospedaje', function($query) {
            $query->where('id_anfitrion', Auth::id());
        })->where('estado', 'confirmada')->count();

        $ingresos = Reserva::whereHas('hospedaje', function($query) {
            $query->where('id_anfitrion', Auth::id());
        })->where('estado', 'confirmada')->sum('total');

        return view('anfitrion.reservas.index', compact('reservas', 'total', 'pendientes', 'confirmadas', 'ingresos'));
    }

    public function show($id)
    {
        // Verificar que la reserva pertenece a un hospedaje del anfitrión
        $reserva = Reserva::with(['usuario', 'hospedaje.anfitrion', 'pago'])
            ->whereHas('hospedaje', function($query) {
                $query->where('id_anfitrion', Auth::id());
            })
            ->where('id_reserva', $id)
            ->firstOrFail();

        $noches = $reserva->diasReservados();

        return view('anfitrion.reservas.show', compact('reserva', 'noches'));
    }
}