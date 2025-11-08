<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PagoController extends Controller
{
    /**
     * Mostrar formulario de pago para una reserva
     */
    public function create($reservaId)
    {
        // Verificar que la reserva existe y pertenece al usuario
        $reserva = Reserva::with(['hospedaje', 'usuario'])
            ->where('id_reserva', $reservaId)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        // Verificar que la reserva está pendiente
        if ($reserva->estado !== 'pendiente') {
            return redirect()->route('reservas.mis-reservas')
                ->with('error', 'Esta reserva ya no está pendiente de pago');
        }

        // Verificar que no tenga ya un pago
        if ($reserva->pago) {
            return redirect()->route('reservas.mis-reservas')
                ->with('error', 'Esta reserva ya tiene un pago registrado');
        }

        $noches = $reserva->diasReservados();

        return view('pagos.create', compact('reserva', 'noches'));
    }

    /**
     * Procesar el pago (simulado)
     */
    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id_reserva',
            'metodo_pago' => 'required|in:yape,plin,tarjeta,paypal',
        ]);

        // Verificar que la reserva pertenece al usuario
        $reserva = Reserva::where('id_reserva', $request->reserva_id)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        // Verificar que no tenga ya un pago
        if ($reserva->pago) {
            return back()->with('error', 'Esta reserva ya tiene un pago registrado');
        }

        // Crear el pago (CORREGIDO: usa los nombres de tu BD)
        $pago = Pago::create([
            'id_reserva' => $reserva->id_reserva,
            'monto' => $reserva->total,
            'metodo' => $request->metodo_pago,           // ← "metodo"
            'estado_pago' => 'completado',               // ← "estado_pago"
            'fecha_pago' => Carbon::now(),
            'referencia_pago' => $this->generarReferencia(), // ← "referencia_pago"
        ]);

        // Actualizar estado de la reserva a "confirmada"
        $reserva->update(['estado' => 'confirmada']);

        // Redirigir a página de éxito
        return redirect()->route('pagos.success', $pago->id_pago)
            ->with('success', '¡Pago procesado exitosamente!');
    }

    /**
     * Mostrar confirmación de pago exitoso
     */
    public function success($pagoId)
    {
        $pago = Pago::with(['reserva.hospedaje.anfitrion', 'reserva.usuario'])
            ->where('id_pago', $pagoId)
            ->whereHas('reserva', function($query) {
                $query->where('id_usuario', Auth::id());
            })
            ->firstOrFail();

        $noches = $pago->reserva->diasReservados();

        return view('pagos.success', compact('pago', 'noches'));
    }

    /**
     * Generar referencia de pago única
     */
    private function generarReferencia()
    {
        return 'TXN-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
    }
}