<?php
namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Hospedaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservaController extends Controller
{
    public function store(Request $request)#procesa la reserva
    {
        
        $request->validate([ #los datos recibidos
            'hospedaje_id' => 'required|exists:hospedajes,id_hospedaje',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'num_huespedes' => 'required|integer|min:1',
        ]);

        $hospedaje = Hospedaje::where('id_hospedaje', $request->hospedaje_id)->firstOrFail();

        if ($request->num_huespedes > $hospedaje->capacidad) { #no exceda la capacidad
            return back()->with('error', 'Número de huéspedes excede la capacidad máxima');
        }

        if ($hospedaje->id_anfitrion == Auth::id()) {
            return back()->with('error', 'No puedes reservar tu propio hospedaje');
        }

        #Verificar disponibilidad (que no haya solapamiento de fechas)
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

        #calcula precio total
        $inicio = Carbon::parse($request->fecha_inicio);
        $fin = Carbon::parse($request->fecha_fin);
        $noches = $inicio->diffInDays($fin);
        $precioTotal = $hospedaje->precio * $noches;

        #Crea la reserva en estado 'pendiente'
        $reserva = Reserva::create([
            'id_hospedaje' => $hospedaje->id_hospedaje,
            'id_usuario' => Auth::id(),
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'num_huespedes' => $request->num_huespedes,
            'total' => $precioTotal,
            'estado' => 'pendiente',
        ]);
        return redirect()->route('reservas.confirmacion', $reserva->id_reserva)
            ->with('success', '¡Reserva creada exitosamente!');
    }

    
    public function confirmacion($id)
    {
        $reserva = Reserva::with(['hospedaje.anfitrion', 'usuario'])
            ->where('id_reserva', $id)
            ->where('id_usuario', Auth::id()) #Solo el dueño puede ver su reserva
            ->firstOrFail();

        $noches = Carbon::parse($reserva->fecha_inicio)
            ->diffInDays(Carbon::parse($reserva->fecha_fin));

        return view('reservas.confirmacion', compact('reserva', 'noches'));
    }

    public function misReservas()
    {
        $reservas = Reserva::with('hospedaje')
            ->where('id_usuario', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reservas.mis-reservas', compact('reservas'));
    }

    public function cancelar($id)
    {
        $reserva = Reserva::where('id_reserva', $id)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        if ($reserva->estado != 'pendiente') {
            return back()->with('error', 'Solo puedes cancelar reservas pendientes');
        }
        $reserva->update(['estado' => 'cancelada']);
        return back()->with('success', 'Reserva cancelada exitosamente');
    }
}