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
    public function index()
    {
        $resenas = Resena::with(['usuario', 'hospedaje', 'reserva'])
            ->orderBy('fecha_resena', 'desc')
            ->paginate(10);

        // Estadísticas para el dashboard
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


    public function create()
    {
        // Obtener reservas completadas que no tienen reseña
        $reservas = Reserva::whereDoesntHave('resena')
            ->where('estado', 'completada')
            ->with(['usuario', 'hospedaje'])
            ->get();

        return view('admin.resenas.create', compact('reservas'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_reserva' => 'required|exists:reservas,id_reserva',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|min:10|max:1000',
        ]);

        // Obtener la reserva para extraer datos relacionados
        $reserva = Reserva::with(['usuario', 'hospedaje'])->find($validated['id_reserva']);

        // Crear la reseña con todos los datos necesarios
        Resena::create([
            'id_reserva' => $validated['id_reserva'],
            'id_usuario' => $reserva->id_usuario,
            'id_hospedaje' => $reserva->id_hospedaje,
            'calificacion' => $validated['calificacion'],
            'comentario' => $validated['comentario'],
            'fecha_resena' => now(),
        ]);

        return redirect()->route('admin.resenas.index')
            ->with('success', 'Reseña creada exitosamente.');
    }

    public function show(string $id)
    {
        $resena = Resena::with(['usuario', 'hospedaje', 'reserva'])
            ->findOrFail($id);

        return view('admin.resenas.show', compact('resena'));
    }


    public function edit(string $id)
    {
        $resena = Resena::with(['reserva', 'usuario', 'hospedaje'])
            ->findOrFail($id);
    
    // Agregar todas las reservas para el select
        $reservas = Reserva::with(['usuario', 'hospedaje'])->get();

        return view('admin.resenas.edit', compact('resena', 'reservas'));
    }

 
    public function update(Request $request, string $id)
    {
        $resena = Resena::findOrFail($id);

        $validated = $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|min:10|max:1000',
        ]);

        $resena->update($validated);

        return redirect()->route('admin.resenas.index')
            ->with('success', 'Reseña actualizada exitosamente.');
    }


    public function destroy(string $id)
    {
        return back()->with('error', '❌ No se pueden eliminar reservas. Son registros contables que deben conservarse. Para cancelar una reserva, edita su estado a "Cancelada".');
    }


    public function toggleVisibility(string $id)
    {
        $resena = Resena::findOrFail($id);
        // Puedes agregar un campo 'estado' en la tabla resenas si necesitas moderación
        return redirect()->back()
            ->with('success', 'Visibilidad de la reseña actualizada.');
    }

    public function filterByRating(Request $request)
    {
        $rating = $request->input('rating');
        
        $resenas = Resena::with(['usuario', 'hospedaje', 'reserva'])
            ->when($rating, function($query) use ($rating) {
                return $query->where('calificacion', $rating);
            })
            ->orderBy('fecha_resena', 'desc')
            ->paginate(10);

        return view('admin.resenas.index', compact('resenas'));
    }
}