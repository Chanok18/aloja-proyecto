<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Hospedaje - Aloja</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        
        .header { background: #1e3a8a; color: white; padding: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .container { max-width: 1000px; margin: 0 auto; padding: 0 20px; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 28px; font-weight: bold; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; }
        
        .page-header { background: white; padding: 30px; border-radius: 8px; margin: 30px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .page-header h1 { color: #1e3a8a; margin-bottom: 10px; }
        .breadcrumb { color: #666; font-size: 14px; }
        
        .form-card { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px; }
        
        .form-section { margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #e5e7eb; }
        .form-section:last-child { border-bottom: none; }
        .form-section h2 { color: #333; margin-bottom: 20px; font-size: 20px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .form-group input, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 5px; font-size: 16px; }
        .form-group textarea { min-height: 120px; resize: vertical; }
        .form-group small { color: #666; font-size: 14px; display: block; margin-top: 5px; }
        
        .form-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        
        .checkbox-group { display: flex; flex-direction: column; gap: 15px; }
        .checkbox-item { display: flex; align-items: center; padding: 15px; background: #f9fafb; border-radius: 8px; border: 2px solid #e5e7eb; cursor: pointer; transition: all 0.3s; }
        .checkbox-item:hover { background: #f3f4f6; border-color: #1e3a8a; }
        .checkbox-item input[type="checkbox"] { width: 24px; height: 24px; margin-right: 12px; cursor: pointer; }
        .checkbox-item label { font-weight: 600; color: #333; cursor: pointer; flex: 1; }
        
        .btn { padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 16px; transition: all 0.3s; }
        .btn-primary { background: #1e3a8a; color: white; }
        .btn-primary:hover { background: #1e40af; }
        .btn-secondary { background: #6b7280; color: white; }
        .btn-secondary:hover { background: #4b5563; }
        
        .form-actions { display: flex; gap: 15px; justify-content: flex-end; margin-top: 30px; }
        
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-error { background: #fee2e2; color: #991b1b; border-left: 4px solid #dc2626; }
        
        /* Estilos para fotos */
        .photos-section { background: #f9fafb; padding: 25px; border-radius: 8px; border: 2px solid #e5e7eb; }
        .photos-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px; }
        .photo-card { position: relative; border: 2px solid #d1d5db; border-radius: 12px; overflow: hidden; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .photo-img { width: 100%; height: 200px; object-fit: cover; }
        .photo-info { padding: 12px; background: white; }
        .photo-badge { background: #10b981; color: white; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .photo-actions { display: flex; gap: 5px; margin-top: 10px; }
        .btn-small { padding: 8px 12px; font-size: 13px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; transition: all 0.3s; }
        .btn-principal { background: #1e3a8a; color: white; flex: 1; }
        .btn-delete { background: #dc2626; color: white; flex: 1; }
        .btn-principal:hover { background: #1e40af; }
        .btn-delete:hover { background: #b91c1c; }
        
        .upload-section { border-top: 2px dashed #d1d5db; padding-top: 20px; margin-top: 20px; }
        .info-box { background: #fef3c7; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b; margin-top: 15px; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">🏠 Aloja</div>
                <div class="nav-links">
                    <a href="{{ route('anfitrion.dashboard') }}">Dashboard</a>
                    <a href="{{ route('anfitrion.hospedajes.index') }}">Mis Hospedajes</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>✏️ Editar Hospedaje</h1>
            <div class="breadcrumb">Dashboard / Mis Hospedajes / Editar</div>
        </div>

        <!-- Mensajes -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>¡Ups! Hay algunos errores:</strong>
                <ul style="margin-top: 10px; margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <div class="form-card">
            <form action="{{ route('anfitrion.hospedajes.update', $hospedaje->id_hospedaje) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="form-section">
                    <h2>📝 Información Básica</h2>
                    
                    <div class="form-group">
                        <label for="titulo">Título del Hospedaje *</label>
                        <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $hospedaje->titulo) }}" required maxlength="255">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción *</label>
                        <textarea id="descripcion" name="descripcion" required>{{ old('descripcion', $hospedaje->descripcion) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="ubicacion">Ubicación *</label>
                        <input type="text" id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $hospedaje->ubicacion) }}" required maxlength="255">
                    </div>
                </div>

                <!-- Detalles del Hospedaje -->
                <div class="form-section">
                    <h2>🏠 Detalles del Hospedaje</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="precio">Precio por Noche (S/.) *</label>
                            <input type="number" id="precio" name="precio" value="{{ old('precio', $hospedaje->precio) }}" required min="0" step="0.01">
                        </div>

                        <div class="form-group">
                            <label for="capacidad">Capacidad (personas) *</label>
                            <input type="number" id="capacidad" name="capacidad" value="{{ old('capacidad', $hospedaje->capacidad) }}" required min="1">
                        </div>
                    </div>
                </div>

                <!-- FOTOS (NUEVO) -->
                @php
                    $fotosActuales = $hospedaje->fotos_galeria;
                    $totalFotos = $fotosActuales->count();
                    $puedeAgregarMas = $totalFotos < 3;
                @endphp

                <div class="form-section">
                    <h2>📸 Fotos del Hospedaje ({{ $totalFotos }} de 3)</h2>

                    @if($fotosActuales->count() > 0)
                        <div class="photos-section">
                            <div class="photos-grid">
                                @foreach($fotosActuales as $foto)
                                    <div class="photo-card">
                                        <img src="{{ asset('storage/' . $foto->ruta_foto) }}" alt="Foto {{ $foto->orden }}" class="photo-img">
                                        <div class="photo-info">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                                <span style="font-weight: 600; font-size: 14px;">Foto {{ $foto->orden }}</span>
                                                @if($foto->es_principal)
                                                    <span class="photo-badge">⭐ Principal</span>
                                                @endif
                                            </div>
                                            <div class="photo-actions">
                                                @if(!$foto->es_principal)
                                                    <button type="button" onclick="marcarPrincipal({{ $foto->id_foto }})" class="btn-small btn-principal">
                                                        ⭐ Principal
                                                    </button>
                                                @endif
                                                <button type="button" onclick="confirmarEliminar({{ $foto->id_foto }})" class="btn-small btn-delete">
                                                    🗑️ Eliminar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($puedeAgregarMas)
                                <div class="upload-section">
                                    <label style="display: block; margin-bottom: 10px; font-weight: 600;">
                                        ➕ Agregar Nuevas Fotos (máximo {{ 3 - $totalFotos }})
                                    </label>
                                    <input type="file" name="fotos[]" accept="image/jpeg,image/jpg,image/png" multiple
                                           style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; background: white;">
                                    <small style="color: #666; display: block; margin-top: 8px;">
                                        Formatos: JPG, PNG. Máximo: 2MB por imagen.
                                    </small>
                                </div>
                            @else
                                <div class="info-box">
                                    <strong>ℹ️ Límite alcanzado:</strong> Ya tienes el máximo de 3 fotos. Elimina alguna si deseas agregar una nueva.
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="photos-section">
                            <p style="color: #666; margin-bottom: 15px;">No tienes fotos aún. Agrega hasta 3 fotos de tu hospedaje.</p>
                            <input type="file" name="fotos[]" accept="image/jpeg,image/jpg,image/png" multiple
                                   style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; background: white;">
                            <small style="color: #666; display: block; margin-top: 8px;">
                                Formatos: JPG, PNG. Máximo: 2MB por imagen. Puedes seleccionar hasta 3 fotos.
                            </small>
                        </div>
                    @endif
                </div>

                <!-- Amenidades -->
                <div class="form-section">
                    <h2>✨ Amenidades</h2>
                    
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="wifi" name="wifi" value="1" {{ old('wifi', $hospedaje->wifi) ? 'checked' : '' }}>
                            <label for="wifi">📶 WiFi</label>
                        </div>

                        <div class="checkbox-item">
                            <input type="checkbox" id="cocina" name="cocina" value="1" {{ old('cocina', $hospedaje->cocina) ? 'checked' : '' }}>
                            <label for="cocina">🍳 Cocina equipada</label>
                        </div>

                        <div class="checkbox-item">
                            <input type="checkbox" id="estacionamiento" name="estacionamiento" value="1" {{ old('estacionamiento', $hospedaje->estacionamiento) ? 'checked' : '' }}>
                            <label for="estacionamiento">🚗 Estacionamiento</label>
                        </div>

                        <div class="checkbox-item">
                            <input type="checkbox" id="aire_acondicionado" name="aire_acondicionado" value="1" {{ old('aire_acondicionado', $hospedaje->aire_acondicionado ?? false) ? 'checked' : '' }}>
                            <label for="aire_acondicionado">❄️ Aire Acondicionado</label>
                        </div>

                        <div class="checkbox-item">
                            <input type="checkbox" id="tv" name="tv" value="1" {{ old('tv', $hospedaje->tv ?? false) ? 'checked' : '' }}>
                            <label for="tv">📺 TV</label>
                        </div>
                    </div>
                </div>

                <!-- Disponibilidad -->
                <div class="form-section">
                    <h2>📅 Disponibilidad</h2>
                    
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="disponible" name="disponible" value="1" {{ old('disponible', $hospedaje->disponible) ? 'checked' : '' }}>
                            <label for="disponible">✅ Marcar como disponible para reservas</label>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="form-actions">
                    <a href="{{ route('anfitrion.hospedajes.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        💾 Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div style="height: 50px;"></div>

    <script>
        function marcarPrincipal(idFoto) {
            if (confirm('¿Marcar esta foto como principal?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('anfitrion.hospedajes.index') }}/' + {{ $hospedaje->id_hospedaje }} + '/fotos/' + idFoto + '/principal';
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'PATCH';
                form.appendChild(method);
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        function confirmarEliminar(idFoto) {
            if (confirm('¿Estás seguro de eliminar esta foto? Esta acción no se puede deshacer.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('anfitrion.hospedajes.index') }}/' + {{ $hospedaje->id_hospedaje }} + '/fotos/' + idFoto;
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>