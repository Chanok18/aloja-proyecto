<?php
namespace App\Http\Controllers\Anfitrion;
use App\Http\Controllers\Controller;
use App\Models\Hospedaje;
use App\Models\HospedajeFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'aire_acondicionado' => 'boolean',
            'tv' => 'boolean',
            'disponible' => 'boolean',
            'fotos.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // NUEVO
        ]);

        // Agregar el ID del anfitrión autenticado
        $validated['id_anfitrion'] = Auth::id();
    
        // Manejar checkboxes
        $validated['wifi'] = $request->has('wifi');
        $validated['cocina'] = $request->has('cocina');
        $validated['estacionamiento'] = $request->has('estacionamiento');
        $validated['aire_acondicionado'] = $request->has('aire_acondicionado');
        $validated['tv'] = $request->has('tv');
        $validated['disponible'] = $request->has('disponible');

        // Crear hospedaje
        $hospedaje = Hospedaje::create($validated);

        // NUEVO: Procesar fotos si fueron subidas
        if ($request->hasFile('fotos')) {
            $fotos = $request->file('fotos');
            $orden = 1;

            foreach ($fotos as $index => $foto) {
                // Generar nombre único
                $nombreArchivo = 'hospedaje_' . $hospedaje->id_hospedaje . '_' . time() . '_' . $orden . '.' . $foto->getClientOriginalExtension();
            
                // Guardar en storage/app/public/hospedajes/
                $ruta = $foto->storeAs('hospedajes', $nombreArchivo, 'public');

                // Crear registro en tabla hospedaje_fotos
                \App\Models\HospedajeFoto::create([
                    'id_hospedaje' => $hospedaje->id_hospedaje,
                    'ruta_foto' => $ruta,
                    'es_principal' => ($index === 0), // Primera foto es principal
                    'orden' => $orden
                ]);

                $orden++;

                // Máximo 3 fotos
                if ($orden > 3) break;
            }
        }

        $numFotos = isset($orden) ? ($orden - 1) : 0;
        $mensaje = $numFotos > 0 
            ? "✅ ¡Hospedaje publicado exitosamente con {$numFotos} foto(s)!" 
            : "✅ ¡Hospedaje publicado exitosamente!";

        return redirect()->route('anfitrion.hospedajes.index')
            ->with('success', $mensaje);
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
        $hospedaje = Hospedaje::with('fotos_galeria') #cargar fotos
            ->where('id_hospedaje', $id)
            ->where('id_anfitrion', Auth::id())
            ->firstOrFail();
        return view('anfitrion.hospedajes.edit', compact('hospedaje'));
    }

    #actualisar hospedaje
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
            'aire_acondicionado' => 'boolean',
            'tv' => 'boolean',
            'disponible' => 'boolean',
            'fotos.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // NUEVO
        ]);

        $validated['wifi'] = $request->has('wifi');
        $validated['cocina'] = $request->has('cocina');
        $validated['estacionamiento'] = $request->has('estacionamiento');
        $validated['aire_acondicionado'] = $request->has('aire_acondicionado');
        $validated['tv'] = $request->has('tv');
        $validated['disponible'] = $request->has('disponible');

        $hospedaje->update($validated);

        #Procesar fotos si fueron subidas
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

                    \App\Models\HospedajeFoto::create([
                        'id_hospedaje' => $hospedaje->id_hospedaje,
                        'ruta_foto' => $ruta,
                        'es_principal' => ($fotosActuales === 0 && $contador === 0),
                        'orden' => $ordenInicial
                    ]);
                    $contador++;
                }
                return redirect()->route('anfitrion.hospedajes.index')
                    ->with('success', "✅ Hospedaje actualizado. Se agregaron {$contador} foto(s).");
            }
        }
        return redirect()->route('anfitrion.hospedajes.index')
            ->with('success', 'Hospedaje actualizado exitosamente');
    }
    #eliminar
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
    #eliminar foto
    public function eliminarFoto($hospedajeId, $fotoId)
    {
        $hospedaje = Hospedaje::where('id_hospedaje', $hospedajeId)
                              ->where('id_anfitrion', Auth::id())
                              ->firstOrFail();
        
        $foto = \App\Models\HospedajeFoto::where('id_foto', $fotoId)
                                         ->where('id_hospedaje', $hospedajeId)
                                         ->firstOrFail();

        #asignar a la q sobra
        if ($foto->es_principal && $hospedaje->fotos_galeria->count() > 1) {
            $otraFoto = $hospedaje->fotos_galeria()
                                  ->where('id_foto', '!=', $fotoId)
                                  ->first();
            if ($otraFoto) {
                $otraFoto->update(['es_principal' => true]);
            }
        }
        #eliminar archivo 
        if (Storage::disk('public')->exists($foto->ruta_foto)) {
            Storage::disk('public')->delete($foto->ruta_foto);
        }
        $foto->delete();
        return redirect()->route('anfitrion.hospedajes.edit', $hospedajeId)
            ->with('success', '✅ Foto eliminada exitosamente.');
    }

    #marcar foto como principal 
    public function marcarPrincipal($hospedajeId, $fotoId)
    {
        $hospedaje = Hospedaje::where('id_hospedaje', $hospedajeId)
                              ->where('id_anfitrion', Auth::id())
                              ->firstOrFail();
        
        // Desmarcar todas las fotos como principal
        \App\Models\HospedajeFoto::where('id_hospedaje', $hospedajeId)
                                 ->update(['es_principal' => false]);

        // Marcar la foto seleccionada como principal
        $foto = \App\Models\HospedajeFoto::where('id_foto', $fotoId)
                                         ->where('id_hospedaje', $hospedajeId)
                                         ->firstOrFail();
        
        $foto->update(['es_principal' => true]);
        return redirect()->route('anfitrion.hospedajes.edit', $hospedajeId)
            ->with('success', '✅ Foto marcada como principal.');
    }
}