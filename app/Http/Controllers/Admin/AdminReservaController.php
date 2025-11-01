<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Hospedaje;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AdminReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'hospedaje'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = Usuario::where('rol', 'viajero')
            ->orWhere('rol', 'admin')
            ->get();
        
        $hospedajes = Hospedaje::where('disponible', true)->get();

        return view('admin.reservas.create', compact('usuarios', 'hospedajes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'id_hospedaje' => 'required|exists:hospedajes,id_hospedaje',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'total' => 'required|numeric|min:0',
            'estado' => 'required|in:pendiente,confirmada,cancelada,completada',
        ]);

        Reserva::create($validated);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reserva = Reserva::with(['usuario', 'hospedaje', 'pago', 'resena'])
            ->findOrFail($id);

        return view('admin.reservas.show', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reserva = Reserva::findOrFail($id);
        
        $usuarios = Usuario::where('rol', 'viajero')
            ->orWhere('rol', 'admin')
            ->get();
        
        $hospedajes = Hospedaje::where('disponible', true)->get();

        return view('admin.reservas.edit', compact('reserva', 'usuarios', 'hospedajes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reserva = Reserva::findOrFail($id);

        $validated = $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'id_hospedaje' => 'required|exists:hospedajes,id_hospedaje',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'total' => 'required|numeric|min:0',
            'estado' => 'required|in:pendiente,confirmada,cancelada,completada',
        ]);

        $reserva->update($validated);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva eliminada exitosamente.');
    }
}
