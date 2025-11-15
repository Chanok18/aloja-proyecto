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

    <form action="{{ route('admin.hospedajes.update', $hospedaje->id_hospedaje) }}" method="POST" style="max-width: 800px;">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <!-- Título -->
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Título *</label>
                <input type="text" name="titulo" value="{{ old('titulo', $hospedaje->titulo) }}" required
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            <!-- Ubicación -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ubicación *</label>
                <input type="text" name="ubicacion" value="{{ old('ubicacion', $hospedaje->ubicacion) }}" required
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            <!-- Anfitrión -->
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

            <!-- Precio -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Precio por noche (S/.) *</label>
                <input type="number" name="precio" value="{{ old('precio', $hospedaje->precio) }}" required min="0" step="0.01"
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            <!-- Capacidad -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Capacidad (personas) *</label>
                <input type="number" name="capacidad" value="{{ old('capacidad', $hospedaje->capacidad) }}" required min="1"
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            <!-- Descripción -->
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción</label>
                <textarea name="descripcion" rows="4"
                          style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">{{ old('descripcion', $hospedaje->descripcion) }}</textarea>
            </div>

            <!-- Amenidades -->
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 10px; font-weight: 600;">Amenidades</label>
                <div style="display: flex; gap: 20px;">
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
            <button type="submit" class="btn btn-primary">Actualizar Hospedaje</button>
            <a href="{{ route('admin.hospedajes.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
@endsection