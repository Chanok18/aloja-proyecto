<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospedaje;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AdminHospedajeController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mostrar todos los hospedajes
     */
    public function index()
    {
        // Obtener todos los hospedajes con información del anfitrión
        $hospedajes = Hospedaje::with('anfitrion')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.hospedajes.index', compact('hospedajes'));
    }

    /**
     * Show the form for creating a new resource.
     * Mostrar formulario para crear hospedaje
     */
    public function create()
    {
        // Obtener todos los anfitriones para el select
        $anfitriones = Usuario::where('rol', 'anfitrion')
            ->orWhere('rol', 'admin')
            ->get();

        return view('admin.hospedajes.create', compact('anfitriones'));
    }

    /**
     * Store a newly created resource in storage.
     * Guardar nuevo hospedaje
     */
    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'id_anfitrion' => 'required|exists:usuarios,id_usuario',
            'titulo' => 'required|string|max:150',
            'ubicacion' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'capacidad' => 'required|integer|min:1',
            'wifi' => 'boolean',
            'cocina' => 'boolean',
            'estacionamiento' => 'boolean',
            'disponible' => 'boolean',
        ]);

        // Manejar los checkboxes (si no están marcados, no vienen en el request)
        $validated['wifi'] = $request->has('wifi');
        $validated['cocina'] = $request->has('cocina');
        $validated['estacionamiento'] = $request->has('estacionamiento');
        $validated['disponible'] = $request->has('disponible') ? true : true; // Por defecto disponible

        // Crear el hospedaje
        Hospedaje::create($validated);

        return redirect()->route('admin.hospedajes.index')
            ->with('success', 'Hospedaje creado exitosamente.');
    }

    /**
     * Display the specified resource.
     * Mostrar un hospedaje específico
     */
    public function show(string $id)
    {
        $hospedaje = Hospedaje::with(['anfitrion', 'reservas', 'resenas'])
            ->findOrFail($id);

        return view('admin.hospedajes.show', compact('hospedaje'));
    }

    /**
     * Show the form for editing the specified resource.
     * Mostrar formulario para editar hospedaje
     */
    public function edit(string $id)
    {
        $hospedaje = Hospedaje::findOrFail($id);
        
        $anfitriones = Usuario::where('rol', 'anfitrion')
            ->orWhere('rol', 'admin')
            ->get();

        return view('admin.hospedajes.edit', compact('hospedaje', 'anfitriones'));
    }

    /**
     * Update the specified resource in storage.
     * Actualizar hospedaje existente
     */
    public function update(Request $request, string $id)
    {
        $hospedaje = Hospedaje::findOrFail($id);

        // Validar datos
        $validated = $request->validate([
            'id_anfitrion' => 'required|exists:usuarios,id_usuario',
            'titulo' => 'required|string|max:150',
            'ubicacion' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'capacidad' => 'required|integer|min:1',
            'wifi' => 'boolean',
            'cocina' => 'boolean',
            'estacionamiento' => 'boolean',
            'disponible' => 'boolean',
        ]);

        // Manejar checkboxes
        $validated['wifi'] = $request->has('wifi');
        $validated['cocina'] = $request->has('cocina');
        $validated['estacionamiento'] = $request->has('estacionamiento');
        $validated['disponible'] = $request->has('disponible');

        // Actualizar
        $hospedaje->update($validated);

        return redirect()->route('admin.hospedajes.index')
            ->with('success', 'Hospedaje actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * Eliminar hospedaje
     */
    public function destroy(string $id)
    {
        $hospedaje = Hospedaje::findOrFail($id);
        $hospedaje->delete();

        return redirect()->route('admin.hospedajes.index')
            ->with('success', 'Hospedaje eliminado exitosamente.');
    }
}