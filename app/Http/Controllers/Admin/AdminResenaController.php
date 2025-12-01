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
    // VER 
    public function index()
    {
        $resenas = Resena::with(['usuario', 'hospedaje', 'reserva'])
            ->orderBy('fecha_resena', 'desc')
            ->paginate(10);

        $totalResenas = Resena::count();
        $resenasPositivas = Resena::where('calificacion', '>=', 4)->count();
        $promedioCalificacion = Resena::avg('calificacion');

        return view('admin.resenas.index', compact(
            'resenas', 
            'totalResenas', 
            'resenasPositivas', 
            'promedioCalificacion'
        ));
    }
    // DETALLE
    public function show(string $id)
    {
        $resena = Resena::with(['usuario', 'hospedaje', 'reserva'])
            ->findOrFail($id);

        return view('admin.resenas.show', compact('resena'));
    }

    // ELIMINAR
    public function destroy(string $id)
    {
        $resena = Resena::findOrFail($id);
        $resena->delete();

        return redirect()->route('admin.resenas.index')
            ->with('success', '✅ Reseña eliminada exitosamente (spam/contenido inapropiado).');
    }
}