<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Hospedaje;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AdminReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'hospedaje'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.reservas.index', compact('reservas'));
    }

    public function create()
    {
        return redirect()->route('admin.reservas.index')
            ->with('error', '❌ Los administradores NO pueden crear reservas. Solo los viajeros pueden hacer reservas.');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.reservas.index')
            ->with('error', '❌ Los administradores NO pueden crear reservas.');
    }

    public function show(string $id)
    {
        $reserva = Reserva::with(['usuario', 'hospedaje', 'pago', 'resena'])
            ->findOrFail($id);

        return view('admin.reservas.show', compact('reserva'));
    }

    public function edit(string $id)
    {
        $reserva = Reserva::with(['usuario', 'hospedaje'])->findOrFail($id);

        return view('admin.reservas.edit', compact('reserva'));
    }

    public function update(Request $request, string $id)
    {
        $reserva = Reserva::findOrFail($id);

        $validated = $request->validate([
            'estado' => 'required|in:pendiente,confirmada,cancelada,completada',
        ]);

        $reserva->update($validated);

        $mensajes = [
            'pendiente' => '⏳ Reserva marcada como PENDIENTE.',
            'confirmada' => '✅ Reserva CONFIRMADA exitosamente.',
            'cancelada' => '❌ Reserva CANCELADA.',
            'completada' => '🎉 Reserva marcada como COMPLETADA.',
        ];

        return redirect()->route('admin.reservas.index')
            ->with('success', $mensajes[$validated['estado']]);
    }
}