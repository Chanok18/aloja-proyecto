<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\Reserva;
use Illuminate\Http\Request;

class AdminPagoController extends Controller
{
    
    public function index()
    {
        $pagos = Pago::with('reserva.usuario', 'reserva.hospedaje')
            ->orderBy('fecha_pago', 'desc')
            ->paginate(10);

        // Estadísticas
        $totalRecaudado = Pago::where('estado_pago', 'completado')->sum('monto');
        $pagosCompletados = Pago::where('estado_pago', 'completado')->count();
        $pagosPendientes = Pago::where('estado_pago', 'pendiente')->count();

        return view('admin.pagos.index', compact('pagos', 'totalRecaudado', 'pagosCompletados', 'pagosPendientes'));
    }

    public function create()
    {
        // Solo reservas confirmadas sin pago
        $reservas = Reserva::whereDoesntHave('pago')
            ->where('estado', 'confirmada')
            ->with(['usuario', 'hospedaje'])
            ->get();

        return view('admin.pagos.create', compact('reservas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_reserva' => 'required|exists:reservas,id_reserva',
            'monto' => 'required|numeric|min:0',
            'metodo' => 'required|in:tarjeta,yape,plin,paypal,transferencia',
            'estado_pago' => 'required|in:pendiente,completado,fallido,reembolsado',
            'referencia_pago' => 'nullable|string|max:100',
        ]);

        Pago::create($validated);

        return redirect()->route('admin.pagos.index')
            ->with('success', 'Pago registrado exitosamente.');
    }


    public function show(string $id)
    {
        $pago = Pago::with(['reserva.usuario', 'reserva.hospedaje'])
            ->findOrFail($id);

        return view('admin.pagos.show', compact('pago'));
    }

 
    public function edit(string $id)
    {
        $pago = Pago::findOrFail($id);
        
        $reservas = Reserva::with(['usuario', 'hospedaje'])->get();

        return view('admin.pagos.edit', compact('pago', 'reservas'));
    }


    public function update(Request $request, string $id)
    {
        $pago = Pago::findOrFail($id);

        $validated = $request->validate([
            'id_reserva' => 'required|exists:reservas,id_reserva',
            'monto' => 'required|numeric|min:0',
            'metodo' => 'required|in:tarjeta,yape,plin,paypal,transferencia',
            'estado_pago' => 'required|in:pendiente,completado,fallido,reembolsado',
            'referencia_pago' => 'nullable|string|max:100',
        ]);

        $pago->update($validated);

        return redirect()->route('admin.pagos.index')
            ->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();

        return redirect()->route('admin.pagos.index')
            ->with('success', 'Pago eliminado exitosamente.');
    }
}
