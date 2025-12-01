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
    // VER TODOS
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
    // ✅ VER DETALLE
    public function show(string $id)
    {
        $hospedaje = Hospedaje::with(['anfitrion', 'reservas.usuario'])
            ->findOrFail($id);
        return view('admin.hospedajes.show', compact('hospedaje'));
    }

    //cambiar disponible
    public function edit(string $id)
    {
        $hospedaje = Hospedaje::with('fotos_galeria')->findOrFail($id);
        $anfitriones = Usuario::where('rol', 'anfitrion')->get();

        return view('admin.hospedajes.edit', compact('hospedaje', 'anfitriones'));
    }

    // ✅ ACTUALIZAR - Solo campos de validación
    public function update(Request $request, string $id)
    {
        $hospedaje = Hospedaje::findOrFail($id);

        // VALIDAR solo los campos que el admin puede cambiar
        $validated = $request->validate([
            'disponible' => 'required|boolean',
            'titulo' => 'required|string|max:150',
            'ubicacion' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'capacidad' => 'required|integer|min:1',
        ]);

        // Actualizar
        $hospedaje->update($validated);

        $mensaje = $validated['disponible'] 
            ? '✅ Hospedaje APROBADO y activado exitosamente.' 
            : '⚠️ Hospedaje DESACTIVADO. El anfitrión será notificado.';

        return redirect()->route('admin.hospedajes.index')
            ->with('success', $mensaje);
    }
    //Eliminar foto (
    public function eliminarFoto($hospedajeId, $fotoId)
    {
        $hospedaje = Hospedaje::findOrFail($hospedajeId);
        $foto = HospedajeFoto::where('id_foto', $fotoId)
                             ->where('id_hospedaje', $hospedajeId)
                             ->firstOrFail();

        if ($foto->es_principal && $hospedaje->fotos_galeria->count() > 1) {
            $otraFoto = $hospedaje->fotos_galeria()
                                  ->where('id_foto', '!=', $fotoId)
                                  ->first();
            if ($otraFoto) {
                $otraFoto->update(['es_principal' => true]);
            }
        }
        if (Storage::disk('public')->exists($foto->ruta_foto)) {
            Storage::disk('public')->delete($foto->ruta_foto);
        }
        $foto->delete();
        return redirect()->route('admin.hospedajes.edit', $hospedajeId)
            ->with('success', '✅ Foto eliminada exitosamente.');
    }

    // Marcar foto como principal
    public function marcarPrincipal($hospedajeId, $fotoId)
    {
        $hospedaje = Hospedaje::findOrFail($hospedajeId);
        HospedajeFoto::where('id_hospedaje', $hospedajeId)
                     ->update(['es_principal' => false]);
        $foto = HospedajeFoto::where('id_foto', $fotoId)
                             ->where('id_hospedaje', $hospedajeId)
                             ->firstOrFail();
        $foto->update(['es_principal' => true]);
        return redirect()->route('admin.hospedajes.edit', $hospedajeId)
            ->with('success', '✅ Foto marcada como principal.');
    }
}