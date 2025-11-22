@extends('layouts.app-dashboard')

@section('title', 'Crear Hospedaje')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Crear Nuevo Hospedaje')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}" class="active">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
@endsection

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.hospedajes.index') }}" class="btn btn-primary">← Volver a la lista</a>
    </div>

    <h2 style="margin-bottom: 30px;">Crear Nuevo Hospedaje</h2>

    @if ($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <strong>¡Ups! Hay algunos errores:</strong>
            <ul style="margin-top: 10px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.hospedajes.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 900px;">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            
            <!-- Título -->
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Título *</label>
                <input type="text" name="titulo" value="{{ old('titulo') }}" required maxlength="150"
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;"
                       placeholder="Ej: Casa acogedora en Miraflores con vista al mar">
            </div>

            <!-- Ubicación -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ubicación *</label>
                <input type="text" name="ubicacion" value="{{ old('ubicacion') }}" required maxlength="150"
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;"
                       placeholder="Ej: Miraflores, Lima">
            </div>

            <!-- Anfitrión -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Anfitrión *</label>
                <select name="id_anfitrion" required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
                    <option value="">Seleccionar anfitrión</option>
                    @foreach($anfitriones as $anfitrion)
                        <option value="{{ $anfitrion->id_usuario }}" {{ old('id_anfitrion') == $anfitrion->id_usuario ? 'selected' : '' }}>
                            {{ $anfitrion->nombre }} {{ $anfitrion->apellido }} ({{ $anfitrion->correo }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Precio -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Precio por noche (S/.) *</label>
                <input type="number" name="precio" value="{{ old('precio') }}" required min="0" step="0.01"
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;"
                       placeholder="150.00">
            </div>

            <!-- Capacidad -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Capacidad (personas) *</label>
                <input type="number" name="capacidad" value="{{ old('capacidad') }}" required min="1"
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;"
                       placeholder="4">
            </div>

            <!-- Descripción -->
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción</label>
                <textarea name="descripcion" rows="4"
                          style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;"
                          placeholder="Describe tu hospedaje, sus características especiales, cercanía a lugares turísticos, etc.">{{ old('descripcion') }}</textarea>
            </div>

            <!-- FOTOS (NUEVO) -->
            <div style="grid-column: 1 / -1; background: #f9fafb; padding: 20px; border-radius: 8px; border: 2px dashed #d1d5db;">
                <label style="display: block; margin-bottom: 10px; font-weight: 600; font-size: 16px;">📸 Fotos del Hospedaje (Máximo 3)</label>
                <p style="color: #666; font-size: 14px; margin-bottom: 15px;">
                    Sube hasta 3 imágenes. La primera será la foto principal que se mostrará en las búsquedas.
                </p>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    <!-- Foto 1 (Principal) -->
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #1e3a8a;">
                            📷 Foto 1 (Principal)
                        </label>
                        <input type="file" name="fotos[]" accept="image/jpeg,image/jpg,image/png"
                               style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 5px; font-size: 14px; background: white;">
                        <small style="color: #666; display: block; margin-top: 5px;">Recomendado: 800x600px</small>
                    </div>

                    <!-- Foto 2 -->
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">
                            📷 Foto 2
                        </label>
                        <input type="file" name="fotos[]" accept="image/jpeg,image/jpg,image/png"
                               style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 5px; font-size: 14px; background: white;">
                        <small style="color: #666; display: block; margin-top: 5px;">Opcional</small>
                    </div>

                    <!-- Foto 3 -->
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">
                            📷 Foto 3
                        </label>
                        <input type="file" name="fotos[]" accept="image/jpeg,image/jpg,image/png"
                               style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 5px; font-size: 14px; background: white;">
                        <small style="color: #666; display: block; margin-top: 5px;">Opcional</small>
                    </div>
                </div>

                <p style="margin-top: 15px; padding: 10px; background: #fef3c7; border-radius: 5px; color: #92400e; font-size: 13px;">
                    ℹ️ <strong>Importante:</strong> Formatos: JPG, PNG, JPEG. Tamaño máximo: 2MB por imagen.
                </p>
            </div>

            <!-- Amenidades (CON 2 NUEVAS) -->
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 10px; font-weight: 600;">Amenidades y Servicios</label>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; background: #f9fafb; border-radius: 5px;">
                        <input type="checkbox" name="wifi" value="1" {{ old('wifi') ? 'checked' : '' }}>
                        <span>📶 WiFi</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; background: #f9fafb; border-radius: 5px;">
                        <input type="checkbox" name="cocina" value="1" {{ old('cocina') ? 'checked' : '' }}>
                        <span>🍳 Cocina</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; background: #f9fafb; border-radius: 5px;">
                        <input type="checkbox" name="estacionamiento" value="1" {{ old('estacionamiento') ? 'checked' : '' }}>
                        <span>🚗 Estacionamiento</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; background: #f9fafb; border-radius: 5px;">
                        <input type="checkbox" name="aire_acondicionado" value="1" {{ old('aire_acondicionado') ? 'checked' : '' }}>
                        <span>❄️ Aire Acondicionado</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; background: #f9fafb; border-radius: 5px;">
                        <input type="checkbox" name="tv" value="1" {{ old('tv') ? 'checked' : '' }}>
                        <span>📺 TV</span>
                    </label>
                </div>
            </div>

            <!-- Disponibilidad -->
            <div style="grid-column: 1 / -1;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 12px; background: #eff6ff; border-radius: 8px; border: 2px solid #1e3a8a;">
                    <input type="checkbox" name="disponible" value="1" {{ old('disponible', true) ? 'checked' : '' }}>
                    <span style="font-weight: 600; color: #1e3a8a;">✅ Marcar como Disponible para Reservas</span>
                </label>
                <small style="color: #666; display: block; margin-top: 5px; margin-left: 30px;">
                    Si está desmarcado, el hospedaje no aparecerá en las búsquedas públicas.
                </small>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">
                💾 Guardar Hospedaje
            </button>
            <a href="{{ route('admin.hospedajes.index') }}" class="btn btn-danger" style="padding: 12px 30px;">
                ❌ Cancelar
            </a>
        </div>
    </form>
@endsection