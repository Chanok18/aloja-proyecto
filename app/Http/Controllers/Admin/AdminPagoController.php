<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\Reserva;
use Illuminate\Http\Request;

class AdminPagoController extends Controller
{
    // VER TODOS
    public function index(Request $request)
    {
        $query = Pago::with('reserva.usuario', 'reserva.hospedaje');

        if ($request->filled('estado_pago')) {
            $query->where('estado_pago', $request->estado_pago);
        }

        if ($request->filled('metodo')) {
            $query->where('metodo', $request->metodo);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_pago', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_pago', '<=', $request->fecha_hasta);
        }

        if ($request->filled('monto_min')) {
            $query->where('monto', '>=', $request->monto_min);
        }

        if ($request->filled('monto_max')) {
            $query->where('monto', '<=', $request->monto_max);
        }

        $pagos = $query->orderBy('fecha_pago', 'desc')->paginate(10);

        $totalRecaudado = Pago::where('estado_pago', 'completado')->sum('monto');
        $pagosCompletados = Pago::where('estado_pago', 'completado')->count();
        $pagosPendientes = Pago::where('estado_pago', 'pendiente')->count();

        return view('admin.pagos.index', compact('pagos', 'totalRecaudado', 'pagosCompletados', 'pagosPendientes'));
    }
    // VER DETALLE
    public function show(string $id)
    {
        $pago = Pago::with(['reserva.usuario', 'reserva.hospedaje'])
            ->findOrFail($id);
        return view('admin.pagos.show', compact('pago'));
    }

    public function edit(string $id)
    {
        $pago = Pago::findOrFail($id);
        return view('admin.pagos.edit', compact('pago'));
    }

    public function update(Request $request, string $id)
    {
        $pago = Pago::findOrFail($id);

        $validated = $request->validate([
            'estado_pago' => 'required|in:pendiente,completado,fallido,reembolsado',
        ]);
        $pago->update($validated);
        $mensajes = [
            'completado' => '✅ Pago VALIDADO como completado.',
            'fallido' => '❌ Pago marcado como FALLIDO.',
            'reembolsado' => '💰 Pago REEMBOLSADO exitosamente.',
            'pendiente' => '⏳ Pago marcado como PENDIENTE.',
        ];

        return redirect()->route('admin.pagos.index')
            ->with('success', $mensajes[$validated['estado_pago']]);
    }

}