@extends('layouts.app-dashboard')

@section('content')
<div style="padding: 30px;">
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #1A1A1A; margin-bottom: 8px;">
            Validar Hospedaje
        </h1>
        <p style="color: #6B7280;">Revisa y aprueba/desactiva el hospedaje publicado por el anfitrión</p>
    </div>

    <!-- Info del Hospedaje -->
    <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #1A1A1A;">
            🏠 Información del Hospedaje
        </h3>
        
        <!-- Galería de Fotos -->
        @if($hospedaje->fotos_galeria->count() > 0)
            <div style="margin-bottom: 24px;">
                <p style="font-size: 14px; font-weight: 600; color: #1A1A1A; margin-bottom: 12px;">📸 Fotos del Hospedaje</p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                    @foreach($hospedaje->fotos_galeria as $foto)
                        <div style="position: relative; border-radius: 8px; overflow: hidden; border: 2px solid {{ $foto->es_principal ? '#10B981' : '#E5E7EB' }};">
                            <img src="{{ asset('storage/' . $foto->ruta_foto) }}" 
                                 alt="Foto" 
                                 style="width: 100%; height: 150px; object-fit: cover;">
                            @if($foto->es_principal)
                                <span style="position: absolute; top: 8px; left: 8px; background: #10B981; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">
                                    ✓ Principal
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Título</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">{{ $hospedaje->titulo }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Ubicación</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">{{ $hospedaje->ubicacion }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Anfitrión</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">{{ $hospedaje->anfitrion->nombre }} {{ $hospedaje->anfitrion->apellido }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Precio por noche</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">S/. {{ number_format($hospedaje->precio, 2) }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Capacidad</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">{{ $hospedaje->capacidad }} personas</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Estado Actual</p>
                <p style="font-size: 16px; font-weight: 600; color: {{ $hospedaje->disponible ? '#10B981' : '#EF4444' }};">
                    {{ $hospedaje->disponible ? '✅ Aprobado y Activo' : '❌ Desactivado' }}
                </p>
            </div>
        </div>

        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #E5E7EB;">
            <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Descripción</p>
            <p style="font-size: 15px; color: #1A1A1A; line-height: 1.6;">
                {{ $hospedaje->descripcion ?? 'Sin descripción' }}
            </p>
        </div>

        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #E5E7EB;">
            <p style="font-size: 13px; color: #6B7280; margin-bottom: 12px;">Amenidades</p>
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <span style="padding: 6px 12px; background: {{ $hospedaje->wifi ? '#D1FAE5' : '#FEE2E2' }}; color: {{ $hospedaje->wifi ? '#065F46' : '#991B1B' }}; border-radius: 6px; font-size: 13px; font-weight: 500;">
                    {{ $hospedaje->wifi ? '✅' : '❌' }} WiFi
                </span>
                <span style="padding: 6px 12px; background: {{ $hospedaje->cocina ? '#D1FAE5' : '#FEE2E2' }}; color: {{ $hospedaje->cocina ? '#065F46' : '#991B1B' }}; border-radius: 6px; font-size: 13px; font-weight: 500;">
                    {{ $hospedaje->cocina ? '✅' : '❌' }} Cocina
                </span>
                <span style="padding: 6px 12px; background: {{ $hospedaje->estacionamiento ? '#D1FAE5' : '#FEE2E2' }}; color: {{ $hospedaje->estacionamiento ? '#065F46' : '#991B1B' }}; border-radius: 6px; font-size: 13px; font-weight: 500;">
                    {{ $hospedaje->estacionamiento ? '✅' : '❌' }} Estacionamiento
                </span>
                <span style="padding: 6px 12px; background: {{ $hospedaje->aire_acondicionado ? '#D1FAE5' : '#FEE2E2' }}; color: {{ $hospedaje->aire_acondicionado ? '#065F46' : '#991B1B' }}; border-radius: 6px; font-size: 13px; font-weight: 500;">
                    {{ $hospedaje->aire_acondicionado ? '✅' : '❌' }} Aire Acondicionado
                </span>
                <span style="padding: 6px 12px; background: {{ $hospedaje->tv ? '#D1FAE5' : '#FEE2E2' }}; color: {{ $hospedaje->tv ? '#065F46' : '#991B1B' }}; border-radius: 6px; font-size: 13px; font-weight: 500;">
                    {{ $hospedaje->tv ? '✅' : '❌' }} TV
                </span>
            </div>
        </div>
    </div>

    <!-- Formulario de Validación -->
    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #1A1A1A;">
            🔍 Validación del Hospedaje
        </h3>

        <form action="{{ route('admin.hospedajes.update', $hospedaje->id_hospedaje) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Campos ocultos para mantener los datos -->
            <input type="hidden" name="titulo" value="{{ $hospedaje->titulo }}">
            <input type="hidden" name="ubicacion" value="{{ $hospedaje->ubicacion }}">
            <input type="hidden" name="descripcion" value="{{ $hospedaje->descripcion }}">
            <input type="hidden" name="precio" value="{{ $hospedaje->precio }}">
            <input type="hidden" name="capacidad" value="{{ $hospedaje->capacidad }}">

            <div style="margin-bottom: 24px;">
                <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 16px; background: #F9FAFB; border: 2px solid #E5E7EB; border-radius: 8px;">
                    <input type="checkbox" 
                           name="disponible" 
                           value="1" 
                           {{ $hospedaje->disponible ? 'checked' : '' }}
                           style="width: 20px; height: 20px; cursor: pointer; accent-color: #10B981;">
                    <div>
                        <p style="font-size: 15px; font-weight: 600; color: #1A1A1A; margin-bottom: 4px;">
                            ✅ Aprobar y Activar Hospedaje
                        </p>
                        <p style="font-size: 13px; color: #6B7280;">
                            El hospedaje será visible para los viajeros en la plataforma
                        </p>
                    </div>
                </label>
            </div>

            <!-- Info Box -->
            <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                <p style="font-size: 14px; color: #78350F; line-height: 1.6;">
                    <strong>ℹ️ Función del Administrador:</strong><br>
                    • Valida que el hospedaje cumpla con los estándares de calidad<br>
                    • Verifica que la información sea correcta y las fotos apropiadas<br>
                    • Activa/desactiva la visibilidad en la plataforma<br>
                    • NO puede modificar los detalles del hospedaje (solo el anfitrión puede)
                </p>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" 
                        style="flex: 1; padding: 14px 24px; background: #2B4F9B; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                    💾 Guardar Validación
                </button>
                <a href="{{ route('admin.hospedajes.index') }}" 
                   style="flex: 1; padding: 14px 24px; background: #F3F4F6; color: #1A1A1A; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; display: block; transition: all 0.2s;">
                    ← Volver
                </a>
            </div>
        </form>
    </div>
</div>
@endsection