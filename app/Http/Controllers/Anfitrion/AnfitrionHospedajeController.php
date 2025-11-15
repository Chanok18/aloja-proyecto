<?php

namespace App\Http\Controllers\Anfitrion;

use App\Http\Controllers\Controller;
use App\Models\Hospedaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnfitrionHospedajeController extends Controller
{
    public function index()
    {
        $hospedajes = Hospedaje::where('id_anfitrion', Auth::id())
            ->withCount('reservas')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calcular estadísticas
        $total = Hospedaje::where('id_anfitrion', Auth::id())->count();
        $activos = Hospedaje::where('id_anfitrion', Auth::id())
            ->where('disponible', true)
            ->count();
        $inactivos = $total - $activos;

        return view('anfitrion.hospedajes.index', compact('hospedajes', 'total', 'activos', 'inactivos'));
    }
    public function create()
    {
        return view('anfitrion.hospedajes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ubicacion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'capacidad' => 'required|integer|min:1',
            'wifi' => 'boolean',
            'cocina' => 'boolean',
            'estacionamiento' => 'boolean',
            'disponible' => 'boolean',
        ]);

        // Agregar el ID del anfitrión
        $validated['id_anfitrion'] = Auth::id();
        $validated['wifi'] = $request->has('wifi');
        $validated['cocina'] = $request->has('cocina');
        $validated['estacionamiento'] = $request->has('estacionamiento');
        $validated['disponible'] = $request->has('disponible');

        Hospedaje::create($validated);

        return redirect()->route('anfitrion.hospedajes.index')
            ->with('success', '¡Hospedaje publicado exitosamente!');
    }

    
     #Mostrar detalle de un hospedaje del anfitrión
    public function show($id)
    {
        $hospedaje = Hospedaje::where('id_hospedaje', $id)
            ->where('id_anfitrion', Auth::id())
            ->withCount('reservas')
            ->firstOrFail();

        // Obtener reservas recientes
        $reservasRecientes = $hospedaje->reservas()
            ->with('usuario')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('anfitrion.hospedajes.show', compact('hospedaje', 'reservasRecientes'));
    }

    
    #Mostrar formulario para editar hospedaje
    
    public function edit($id)
    {
        $hospedaje = Hospedaje::where('id_hospedaje', $id)
            ->where('id_anfitrion', Auth::id())
            ->firstOrFail();

        return view('anfitrion.hospedajes.edit', compact('hospedaje'));
    }

    /**
     * Actualizar hospedaje
     */
    public function update(Request $request, $id)
    {
        $hospedaje = Hospedaje::where('id_hospedaje', $id)
            ->where('id_anfitrion', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ubicacion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'capacidad' => 'required|integer|min:1',
            'wifi' => 'boolean',
            'cocina' => 'boolean',
            'estacionamiento' => 'boolean',
            'disponible' => 'boolean',
        ]);

        $validated['wifi'] = $request->has('wifi');
        $validated['cocina'] = $request->has('cocina');
        $validated['estacionamiento'] = $request->has('estacionamiento');
        $validated['disponible'] = $request->has('disponible');

        $hospedaje->update($validated);

        return redirect()->route('anfitrion.hospedajes.index')
            ->with('success', 'Hospedaje actualizado exitosamente');
    }

    /**
     * Eliminar hospedaje
     */
    public function destroy($id)
    {
        $hospedaje = Hospedaje::where('id_hospedaje', $id)
            ->where('id_anfitrion', Auth::id())
            ->firstOrFail();

        // Verificar que no tenga reservas activas
        $reservasActivas = $hospedaje->reservas()
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->count();

        if ($reservasActivas > 0) {
            return back()->with('error', 'No puedes eliminar un hospedaje con reservas activas');
        }

        $hospedaje->delete();

        return redirect()->route('anfitrion.hospedajes.index')
            ->with('success', 'Hospedaje eliminado exitosamente');
    }
}