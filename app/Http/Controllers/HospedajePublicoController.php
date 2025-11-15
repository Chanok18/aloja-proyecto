<?php

namespace App\Http\Controllers;

use App\Models\Hospedaje;
use Illuminate\Http\Request;

class HospedajePublicoController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Hospedaje::with('anfitrion')
            ->where('disponible', true);

        // Filtro por ubicación
        if ($request->filled('ubicacion')) {
            $query->where('ubicacion', 'like', '%' . $request->ubicacion . '%');
        }

        // Filtro por precio máximo
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        // Filtro por capacidad
        if ($request->filled('capacidad')) {
            $query->where('capacidad', '>=', $request->capacidad);
        }

        // Filtros de amenidades
        if ($request->filled('wifi')) {
            $query->where('wifi', true);
        }
        if ($request->filled('cocina')) {
            $query->where('cocina', true);
        }
        if ($request->filled('estacionamiento')) {
            $query->where('estacionamiento', true);
        }

        $hospedajes = $query->paginate(12);

        return view('publico.hospedajes.index', compact('hospedajes'));
    }

    public function show($id)
    {
        $hospedaje = Hospedaje::with(['anfitrion', 'resenas.usuario'])
            ->where('disponible', true)
            ->findOrFail($id);
        return view('publico.hospedajes.show', compact('hospedaje'));
    }
}
