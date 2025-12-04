<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resena;
use App\Models\Reserva;
use App\Models\Usuario;
use App\Models\Hospedaje;

class AdminResenaController extends Controller
{
    public function index(Request $request)
    {
        // Query base con relaciones
        $query = Resena::with(['usuario', 'hospedaje', 'reserva']);

        // FILTRO 1: Por Calificación
        if ($request->filled('calificacion')) {
            $query->where('calificacion', $request->calificacion);
        }

        // FILTRO 2: Por Usuario
        if ($request->filled('usuario_id')) {
            $query->where('id_usuario', $request->usuario_id);
        }

        // FILTRO 3: Por Hospedaje
        if ($request->filled('hospedaje_id')) {
            $query->where('id_hospedaje', $request->hospedaje_id);
        }

        // FILTRO 4: Por Rango de Fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_resena', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_resena', '<=', $request->fecha_hasta);
        }

        // Obtener resultados con paginación
        $resenas = $query->orderBy('fecha_resena', 'desc')->paginate(10);

        // Estadísticas
        $totalResenas = Resena::count();
        $resenasPositivas = Resena::where('calificacion', '>=', 4)->count();
        $promedioCalificacion = Resena::avg('calificacion');

        // Datos para filtros
        $usuarios = Usuario::where('rol', 'viajero')->orderBy('nombre')->get();
        $hospedajes = Hospedaje::orderBy('titulo')->get();

        return view('admin.resenas.index', compact(
            'resenas', 
            'totalResenas', 
            'resenasPositivas', 
            'promedioCalificacion',
            'usuarios',
            'hospedajes'
        ));
    }

    public function show(string $id)
    {
        $resena = Resena::with(['usuario', 'hospedaje', 'reserva'])
            ->findOrFail($id);

        return view('admin.resenas.show', compact('resena'));
    }

    public function destroy(string $id)
    {
        $resena = Resena::findOrFail($id);
        $resena->delete();

        return redirect()->route('admin.resenas.index')
            ->with('success', '✅ Reseña eliminada exitosamente (spam/contenido inapropiado).');
    }
}