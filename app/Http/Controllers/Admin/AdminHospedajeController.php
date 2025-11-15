<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Hospedaje;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AdminHospedajeController extends Controller
{
    
     #Muestra la lista de todos los hospedajes con paginación
    public function index()
    {
        // Obtener hospedajes con información del anfitrion
        $hospedajes = Hospedaje::with('anfitrion')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calcula estadisticas para el dashboard
        $total = Hospedaje::count();
        $disponibles = Hospedaje::where('disponible', true)->count();
        $nodisponibles = $total - $disponibles;
        return view('admin.hospedajes.index', compact('hospedajes', 'total', 'disponibles', 'nodisponibles'));
    }

    
    #Muestra el formulario para crear un nuevo hospedaje
    
    public function create()
    {
        // Obtener solo usuarios con rol 'anfitrion' para asignar el hospedaje
        $anfitriones = Usuario::where('rol', 'anfitrion')->get();
        return view('admin.hospedajes.create', compact('anfitriones'));
    }

    /**
     * Guarda un nuevo hospedaje en la bd
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
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
        #maneja los check
        $validated['wifi'] = $request->has('wifi');
        $validated['cocina'] = $request->has('cocina');
        $validated['estacionamiento'] = $request->has('estacionamiento');
        $validated['disponible'] = $request->has('disponible');

        // Crear el hospedaje
        Hospedaje::create($validated);
        return redirect()->route('admin.hospedajes.index')
            ->with('success', 'Hospedaje creado exitosamente.');
    }

    
    public function show(string $id)#muestra el detalle 
    {
        $hospedaje = Hospedaje::with(['anfitrion', 'reservas.usuario'])
            ->findOrFail($id);

        return view('admin.hospedajes.show', compact('hospedaje'));
    }

    
    public function edit(string $id)#form para editar
    {
        $hospedaje = Hospedaje::findOrFail($id);
        $anfitriones = Usuario::where('rol', 'anfitrion')->get();

        return view('admin.hospedajes.edit', compact('hospedaje', 'anfitriones'));
    }

    
    public function update(Request $request, string $id)#actualiza los datos
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

        $validated['wifi'] = $request->has('wifi');
        $validated['cocina'] = $request->has('cocina');
        $validated['estacionamiento'] = $request->has('estacionamiento');
        $validated['disponible'] = $request->has('disponible');
        $hospedaje->update($validated);

        return redirect()->route('admin.hospedajes.index')
            ->with('success', 'Hospedaje actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $hospedaje = Hospedaje::findOrFail($id);

        // Verificar que no tenga reservas
        if ($hospedaje->reservas()->whereIn('estado', ['pendiente', 'confirmada'])->exists()) {
            return back()->with('error', 'No se puede eliminar un hospedaje con reservas activas.');
        }
        $hospedaje->delete();
        return redirect()->route('admin.hospedajes.index')
            ->with('success', 'Hospedaje eliminado exitosamente.');
    }
}