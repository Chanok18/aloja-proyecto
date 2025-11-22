@extends('layouts.app-dashboard')
@section('title', 'Editar Hospedaje')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Editar Hospedaje')
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

    <h2 style="margin-bottom: 30px;">Editar Hospedaje #{{ $hospedaje->id_hospedaje }}</h2>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

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

    <form action="{{ route('admin.hospedajes.update', $hospedaje->id_hospedaje) }}" method="POST" enctype="multipart/form-data" style="max-width: 900px;">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            
            #Título
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Título *</label>
                <input type="text" name="titulo" value="{{ old('titulo', $hospedaje->titulo) }}" required
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            #Ubicación
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ubicación *</label>
                <input type="text" name="ubicacion" value="{{ old('ubicacion', $hospedaje->ubicacion) }}" required
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            #Anfitrión
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Anfitrión *</label>
                <select name="id_anfitrion" required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
                    @foreach($anfitriones as $anfitrion)
                        <option value="{{ $anfitrion->id_usuario }}" 
                            {{ old('id_anfitrion', $hospedaje->id_anfitrion) == $anfitrion->id_usuario ? 'selected' : '' }}>
                            {{ $anfitrion->nombre }} {{ $anfitrion->apellido }}
                        </option>
                    @endforeach
                </select>
            </div>

            #Precio
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Precio por noche (S/.) *</label>
                <input type="number" name="precio" value="{{ old('precio', $hospedaje->precio) }}" required min="0" step="0.01"
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            #Capacidad
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Capacidad (personas) *</label>
                <input type="number" name="capacidad" value="{{ old('capacidad', $hospedaje->capacidad) }}" required min="1"
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            #Descripción
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción</label>
                <textarea name="descripcion" rows="4"
                          style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">{{ old('descripcion', $hospedaje->descripcion) }}</textarea>
            </div>

            #FOTOS
            @php
                $fotosActuales = $hospedaje->fotos_galeria;
                $totalFotos = $fotosActuales->count();
                $puedeAgregarMas = $totalFotos < 3;
            @endphp

            <div style="grid-column: 1 / -1; background: #f9fafb; padding: 20px; border-radius: 8px; border: 2px solid #e5e7eb;">
                <label style="display: block; margin-bottom: 15px; font-weight: 600; font-size: 16px;">
                    📸 Fotos del Hospedaje ({{ $totalFotos }} de 3)
                </label>

                @if($fotosActuales->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                        @foreach($fotosActuales as $foto)
                            <div style="position: relative; border: 2px solid #d1d5db; border-radius: 8px; overflow: hidden; background: white;">
                                <!-- Imagen -->
                                <img src="{{ asset('storage/' . $foto->ruta_foto) }}" 
                                     alt="Foto {{ $foto->orden }}" 
                                     style="width: 100%; height: 180px; object-fit: cover;">
                                
                                <!-- Info -->
                                <div style="padding: 10px; background: white;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-weight: 600; font-size: 13px;">
                                            Foto {{ $foto->orden }}
                                            @if($foto->es_principal)
                                                <span style="background: #10b981; color: white; padding: 2px 8px; border-radius: 10px; font-size: 11px; margin-left: 5px;">
                                                    ⭐ Principal
                                                </span>
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <!-- Botones -->
                                    <div style="display: flex; gap: 5px;">
                                        @if(!$foto->es_principal)
                                            <button type="button" onclick="marcarPrincipal({{ $foto->id_foto }})" 
                                                    style="flex: 1; padding: 6px; background: #1e3a8a; color: white; border: none; border-radius: 5px; font-size: 12px; cursor: pointer;">
                                                ⭐ Marcar Principal
                                            </button>
                                        @endif
                                        
                                        <button type="button" onclick="confirmarEliminar({{ $foto->id_foto }})" 
                                                style="flex: 1; padding: 6px; background: #dc2626; color: white; border: none; border-radius: 5px; font-size: 12px; cursor: pointer;">
                                            🗑️ Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: #666; margin-bottom: 15px;">No hay fotos aún. Agrega hasta 3 fotos.</p>
                @endif

                <!-- Agregar Nuevas Fotos -->
                @if($puedeAgregarMas)
                    <div style="border-top: 2px dashed #d1d5db; padding-top: 20px;">
                        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
                            ➕ Agregar Nuevas Fotos (máximo {{ 3 - $totalFotos }})
                        </label>
                        <input type="file" name="fotos[]" accept="image/jpeg,image/jpg,image/png" multiple
                               style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px; background: white;">
                        <small style="color: #666; display: block; margin-top: 5px;">
                            Formatos: JPG, PNG. Máximo: 2MB por imagen. Puedes seleccionar múltiples archivos.
                        </small>
                    </div>
                @else
                    <p style="background: #fef3c7; padding: 12px; border-radius: 5px; color: #92400e; font-size: 14px;">
                        ℹ️ Ya tienes el máximo de 3 fotos. Elimina alguna si deseas agregar una nueva.
                    </p>
                @endif
            </div>

            <!-- Amenidades -->
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 10px; font-weight: 600;">Amenidades</label>
                <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <label style="display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="wifi" value="1" {{ old('wifi', $hospedaje->wifi) ? 'checked' : '' }}>
                        📶 WiFi
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="cocina" value="1" {{ old('cocina', $hospedaje->cocina) ? 'checked' : '' }}>
                        🍳 Cocina
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="estacionamiento" value="1" {{ old('estacionamiento', $hospedaje->estacionamiento) ? 'checked' : '' }}>
                        🚗 Estacionamiento
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="disponible" value="1" {{ old('disponible', $hospedaje->disponible) ? 'checked' : '' }}>
                        ✅ Disponible
                    </label>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">💾 Actualizar Hospedaje</button>
            <a href="{{ route('admin.hospedajes.index') }}" class="btn btn-danger">❌ Cancelar</a>
        </div>
    </form>

    <script>
        // Marcar foto como principal
        function marcarPrincipal(idFoto) {
            if (confirm('¿Marcar esta foto como principal?')) {
                // Crear formulario temporal
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.hospedajes.index') }}/' + {{ $hospedaje->id_hospedaje }} + '/fotos/' + idFoto + '/principal';
                
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

        // Eliminar foto
        function confirmarEliminar(idFoto) {
            if (confirm('¿Estás seguro de eliminar esta foto? Esta acción no se puede deshacer.')) {
                // Crear formulario temporal
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.hospedajes.index') }}/' + {{ $hospedaje->id_hospedaje }} + '/fotos/' + idFoto;
                
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
@endsection