<?php
namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Hospedaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        // VALIDACIÓN 1: Validar datos básicos
        $request->validate([
            'hospedaje_id' => 'required|exists:hospedajes,id_hospedaje',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'num_huespedes' => 'required|integer|min:1',
        ], [
            'hospedaje_id.required' => 'Debe seleccionar un hospedaje',
            'hospedaje_id.exists' => 'El hospedaje seleccionado no existe',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria',
            'fecha_inicio.after_or_equal' => 'La fecha de inicio no puede ser anterior a hoy',
            'fecha_fin.required' => 'La fecha de fin es obligatoria',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio',
            'num_huespedes.required' => 'El número de huéspedes es obligatorio',
            'num_huespedes.min' => 'Debe haber al menos 1 huésped',
        ]);

        // Obtener el hospedaje
        $hospedaje = Hospedaje::where('id_hospedaje', $request->hospedaje_id)->firstOrFail();

        // VALIDACIÓN 2: Verificar que el hospedaje esté disponible (activo)
        if (!$hospedaje->disponible) {
            return back()
                ->withInput()
                ->with('error', '❌ Este hospedaje no está disponible actualmente. Por favor, elige otro.');
        }

        // VALIDACIÓN 3: No exceder la capacidad
        if ($request->num_huespedes > $hospedaje->capacidad) {
            return back()
                ->withInput()
                ->with('error', "❌ Número de huéspedes ({$request->num_huespedes}) excede la capacidad máxima del hospedaje ({$hospedaje->capacidad} personas).");
        }

        // VALIDACIÓN 4: No reservar tu propio hospedaje
        if ($hospedaje->id_anfitrion == Auth::id()) {
            return back()
                ->withInput()
                ->with('error', '❌ No puedes reservar tu propio hospedaje. Como anfitrión, gestiona tus reservas desde tu panel.');
        }

        // VALIDACIÓN 5: Calcular noches (mínimo 1 noche)
        $inicio = Carbon::parse($request->fecha_inicio);
        $fin = Carbon::parse($request->fecha_fin);
        $noches = $inicio->diffInDays($fin);

        if ($noches < 1) {
            return back()
                ->withInput()
                ->with('error', '❌ La reserva debe ser de al menos 1 noche.');
        }

        // VALIDACIÓN 6: Verificar disponibilidad (sin solapamiento de fechas)
        $solapamiento = Reserva::where('id_hospedaje', $hospedaje->id_hospedaje)
            ->where('estado', '!=', 'cancelada')
            ->where(function($query) use ($request) {
                $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])
                      ->orWhereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin])
                      ->orWhere(function($q) use ($request) {
                          $q->where('fecha_inicio', '<=', $request->fecha_inicio)
                            ->where('fecha_fin', '>=', $request->fecha_fin);
                      });
            })
            ->exists();

        if ($solapamiento) {
            return back()
                ->withInput()
                ->with('error', '❌ El hospedaje no está disponible en las fechas seleccionadas. Ya existe una reserva activa en ese período. Por favor, elige otras fechas.');
        }

        // VALIDACIÓN 7: Verificar estancia máxima (opcional - máximo 30 días)
        if ($noches > 30) {
            return back()
                ->withInput()
                ->with('error', '❌ La estancia máxima permitida es de 30 noches. Tu reserva es de ' . $noches . ' noches.');
        }

        // CALCULAR PRECIO TOTAL
        $precioTotal = $hospedaje->precio * $noches;

        // CREAR LA RESERVA
        try {
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
                ->with('success', '✅ ¡Reserva creada exitosamente! Procede al pago para confirmar tu reserva.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', '❌ Error al crear la reserva: ' . $e->getMessage() . '. Por favor, intenta nuevamente.');
        }
    }

    public function confirmacion($id)
    {
        // Solo el usuario dueño de la reserva puede verla
        $reserva = Reserva::with(['hospedaje.anfitrion', 'usuario'])
            ->where('id_reserva', $id)
            ->where('id_usuario', Auth::id())
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

        // VALIDACIÓN 1: Solo cancelar reservas pendientes
        if ($reserva->estado != 'pendiente') {
            return back()->with('error', '❌ Solo puedes cancelar reservas en estado pendiente. Esta reserva está: ' . $reserva->estado);
        }

        // VALIDACIÓN 2: Verificar que no tenga pago completado
        if ($reserva->pago && $reserva->pago->estaCompletado()) {
            return back()->with('error', '❌ No puedes cancelar una reserva con pago completado. Contacta a soporte para solicitar reembolso.');
        }

        // VALIDACIÓN 3: Verificar tiempo de anticipación (opcional - al menos 24 horas antes)
        $horasDeAnticipacion = Carbon::now()->diffInHours(Carbon::parse($reserva->fecha_inicio), false);
        
        if ($horasDeAnticipacion < 24 && $horasDeAnticipacion > 0) {
            return back()->with('warning', '⚠️ Estás cancelando con menos de 24 horas de anticipación.');
        }

        // Cancelar la reserva
        $reserva->update(['estado' => 'cancelada']);

        return back()->with('success', '✅ Reserva cancelada exitosamente. Tu reserva ha sido cancelada correctamente.');
    }
}