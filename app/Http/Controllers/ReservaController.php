<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Hospedaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Procesar la creación de una nueva reserva
     */
    public function store(Request $request)
    {
        // 1. Validar datos de entrada
        $request->validate([
            'hospedaje_id' => 'required|exists:hospedajes,id_hospedaje',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'num_huespedes' => 'required|integer|min:1',
        ]);

        // 2. Obtener el hospedaje
        $hospedaje = Hospedaje::where('id_hospedaje', $request->hospedaje_id)->firstOrFail();

        // 3. Validar capacidad
        if ($request->num_huespedes > $hospedaje->capacidad) {
            return back()->with('error', 'Número de huéspedes excede la capacidad máxima');
        }

        // 4. Validar que no sea su propio hospedaje
        if ($hospedaje->anfitrion_id == Auth::id()) {
            return back()->with('error', 'No puedes reservar tu propio hospedaje');
        }

        // 5. Verificar disponibilidad (CORREGIDO: usa id_hospedaje)
        $disponible = Reserva::where('id_hospedaje', $hospedaje->id_hospedaje)
            ->where('estado', '!=', 'cancelada')
            ->where(function($query) use ($request) {
                $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])
                      ->orWhereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin])
                      ->orWhere(function($q) use ($request) {
                          $q->where('fecha_inicio', '<=', $request->fecha_inicio)
                            ->where('fecha_fin', '>=', $request->fecha_fin);
                      });
            })
            ->doesntExist();

        if (!$disponible) {
            return back()->with('error', 'El hospedaje no está disponible en esas fechas');
        }

        // 6. Calcular precio total
        $inicio = Carbon::parse($request->fecha_inicio);
        $fin = Carbon::parse($request->fecha_fin);
        $noches = $inicio->diffInDays($fin);
        $precioTotal = $hospedaje->precio * $noches;

        // 7. Crear la reserva (CORREGIDO: usa id_usuario, id_hospedaje, total)
        $reserva = Reserva::create([
            'id_hospedaje' => $hospedaje->id_hospedaje,
            'id_usuario' => Auth::id(),
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'num_huespedes' => $request->num_huespedes,
            'total' => $precioTotal,  // ← Es "total", no "precio_total"
            'estado' => 'pendiente',
        ]);

        // 8. Redirigir a confirmación
        return redirect()->route('reservas.confirmacion', $reserva->id_reserva)
            ->with('success', '¡Reserva creada exitosamente!');
    }

    /**
     * Mostrar confirmación de reserva
     */
    public function confirmacion($id)
    {
        $reserva = Reserva::with(['hospedaje.anfitrion', 'usuario'])
            ->where('id_reserva', $id)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        $noches = Carbon::parse($reserva->fecha_inicio)
            ->diffInDays(Carbon::parse($reserva->fecha_fin));

        return view('reservas.confirmacion', compact('reserva', 'noches'));
    }

    /**
     * Mostrar mis reservas
     */
    public function misReservas()
    {
        $reservas = Reserva::with('hospedaje')
            ->where('id_usuario', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reservas.mis-reservas', compact('reservas'));
    }

    /**
     * Cancelar una reserva
     */
    public function cancelar($id)
    {
        $reserva = Reserva::where('id_reserva', $id)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        // Solo se pueden cancelar reservas pendientes
        if ($reserva->estado != 'pendiente') {
            return back()->with('error', 'Solo puedes cancelar reservas pendientes');
        }

        $reserva->update(['estado' => 'cancelada']);

        return back()->with('success', 'Reserva cancelada exitosamente');
    }
}