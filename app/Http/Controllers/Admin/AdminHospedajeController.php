<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Hospedaje;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Models\HospedajeFoto;
use Illuminate\Support\Facades\Storage;

class AdminHospedajeController extends Controller
{
    
    public function index()
    {
        $hospedajes = Hospedaje::with(['anfitrion', 'fotos_galeria'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $total = Hospedaje::count();
        $disponibles = Hospedaje::where('disponible', true)->count();
        $nodisponibles = $total - $disponibles;
        return view('admin.hospedajes.index', compact('hospedajes', 'total', 'disponibles', 'nodisponibles'));
    }

    
    public function create()
    {
        $anfitriones = Usuario::where('rol', 'anfitrion')->get();
        return view('admin.hospedajes.create', compact('anfitriones'));
    }

    
    public function store(Request $request)
    {
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
            'fotos.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $validated['wifi'] = $request->has('wifi');
        $validated['cocina'] = $request->has('cocina');
        $validated['estacionamiento'] = $request->has('estacionamiento');
        $validated['aire_acondicionado'] = $request->has('aire_acondicionado');
        $validated['tv'] = $request->has('tv');
        $validated['disponible'] = $request->has('disponible');

        $hospedaje = Hospedaje::create($validated);

        if ($request->hasFile('fotos')) {
            $fotos = $request->file('fotos');
            $orden = 1;

            foreach ($fotos as $index => $foto) {
                $nombreArchivo = 'hospedaje_' . $hospedaje->id_hospedaje . '_' . time() . '_' . $orden . '.' . $foto->getClientOriginalExtension();
                $ruta = $foto->storeAs('hospedajes', $nombreArchivo, 'public');

                HospedajeFoto::create([
                    'id_hospedaje' => $hospedaje->id_hospedaje,
                    'ruta_foto' => $ruta,
                    'es_principal' => ($index === 0),
                    'orden' => $orden
                ]);

                $orden++;
                if ($orden > 3) break;
            }
        }

        return redirect()->route('admin.hospedajes.index')
            ->with('success', '✅ Hospedaje creado exitosamente con ' . (isset($orden) ? ($orden - 1) : 0) . ' foto(s).');
    }

    
    public function show(string $id)
    {
        $hospedaje = Hospedaje::with(['anfitrion', 'reservas.usuario'])
            ->findOrFail($id);

        return view('admin.hospedajes.show', compact('hospedaje'));
    }

    
    public function edit(string $id)
    {
        $hospedaje = Hospedaje::with('fotos_galeria')->findOrFail($id);
        $anfitriones = Usuario::where('rol', 'anfitrion')->get();

        return view('admin.hospedajes.edit', compact('hospedaje', 'anfitriones'));
    }

    
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
            'fotos.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $validated['wifi'] = $request->has('wifi');
        $validated['cocina'] = $request->has('cocina');
        $validated['estacionamiento'] = $request->has('estacionamiento');
        $validated['disponible'] = $request->has('disponible');
        
        $hospedaje->update($validated);

        // Procesar nuevas fotos si fueron subidas
        if ($request->hasFile('fotos')) {
            $fotosActuales = $hospedaje->fotos_galeria->count();
            $espacioDisponible = 3 - $fotosActuales;

            if ($espacioDisponible > 0) {
                $fotos = $request->file('fotos');
                $contador = 0;
                $ordenInicial = $hospedaje->fotos_galeria->max('orden') ?? 0;

                foreach ($fotos as $foto) {
                    if ($contador >= $espacioDisponible) break;

                    $ordenInicial++;
                    $nombreArchivo = 'hospedaje_' . $hospedaje->id_hospedaje . '_' . time() . '_' . $ordenInicial . '.' . $foto->getClientOriginalExtension();
                    $ruta = $foto->storeAs('hospedajes', $nombreArchivo, 'public');

                    HospedajeFoto::create([
                        'id_hospedaje' => $hospedaje->id_hospedaje,
                        'ruta_foto' => $ruta,
                        'es_principal' => ($fotosActuales === 0 && $contador === 0), // Si no hay fotos, la primera es principal
                        'orden' => $ordenInicial
                    ]);

                    $contador++;
                }

                return redirect()->route('admin.hospedajes.edit', $id)
                    ->with('success', "✅ Hospedaje actualizado. Se agregaron {$contador} foto(s).");
            }
        }

        return redirect()->route('admin.hospedajes.edit', $id)
            ->with('success', '✅ Hospedaje actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        return back()->with('error', '❌ No se pueden eliminar hospedajes. Para desactivar un hospedaje, edítalo y marca "Disponible" como NO.');
    }

    // NUEVO: Eliminar foto
    public function eliminarFoto($hospedajeId, $fotoId)
    {
        $hospedaje = Hospedaje::findOrFail($hospedajeId);
        $foto = HospedajeFoto::where('id_foto', $fotoId)
                             ->where('id_hospedaje', $hospedajeId)
                             ->firstOrFail();

        // No permitir eliminar si es la única foto principal
        if ($foto->es_principal && $hospedaje->fotos_galeria->count() > 1) {
            // Asignar otra foto como principal antes de eliminar
            $otraFoto = $hospedaje->fotos_galeria()
                                  ->where('id_foto', '!=', $fotoId)
                                  ->first();
            if ($otraFoto) {
                $otraFoto->update(['es_principal' => true]);
            }
        }

        // Eliminar archivo físico
        if (Storage::disk('public')->exists($foto->ruta_foto)) {
            Storage::disk('public')->delete($foto->ruta_foto);
        }

        // Eliminar registro de BD
        $foto->delete();

        return redirect()->route('admin.hospedajes.edit', $hospedajeId)
            ->with('success', '✅ Foto eliminada exitosamente.');
    }

    // NUEVO: Marcar foto como principal
    public function marcarPrincipal($hospedajeId, $fotoId)
    {
        $hospedaje = Hospedaje::findOrFail($hospedajeId);
        
        // Desmarcar todas las fotos como principal
        HospedajeFoto::where('id_hospedaje', $hospedajeId)
                     ->update(['es_principal' => false]);

        // Marcar la foto seleccionada como principal
        $foto = HospedajeFoto::where('id_foto', $fotoId)
                             ->where('id_hospedaje', $hospedajeId)
                             ->firstOrFail();
        
        $foto->update(['es_principal' => true]);

        return redirect()->route('admin.hospedajes.edit', $hospedajeId)
            ->with('success', '✅ Foto marcada como principal.');
    }
}