@extends('layouts.app-dashboard')

@section('title', 'Editar Reseña')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Editar Reseña')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}" class="active">⭐ Reseñas</a>
@endsection

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.resenas.index') }}" class="btn btn-primary">← Volver a la lista</a>
    </div>

    <h2 style="margin-bottom: 30px;">Editar Reseña #{{ $resena->id_resena }}</h2>

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

    <form action="{{ route('admin.resenas.update', $resena->id_resena) }}" method="POST" style="max-width: 800px;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <!-- Reserva -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Reserva *</label>
                <select name="id_reserva" required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
                    @foreach($reservas as $reserva)
                        <option value="{{ $reserva->id_reserva }}" 
                            {{ old('id_reserva', $resena->id_reserva) == $reserva->id_reserva ? 'selected' : '' }}>
                            #{{ $reserva->id_reserva }} - {{ $reserva->hospedaje->titulo }} - {{ $reserva->usuario->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Calificación -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Calificación *</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    @for($i = 1; $i <= 5; $i++)
                        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                            <input type="radio" name="calificacion" value="{{ $i }}" 
                                {{ old('calificacion', $resena->calificacion) == $i ? 'checked' : '' }} required>
                            <span style="font-size: 24px; color: #f59e0b;">
                                @for($j = 1; $j <= $i; $j++)⭐@endfor
                            </span>
                            <span>{{ $i }} estrella{{ $i > 1 ? 's' : '' }}</span>
                        </label>
                    @endfor
                </div>
            </div>

            <!-- Comentario -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Comentario</label>
                <textarea name="comentario" rows="6"
                          style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">{{ old('comentario', $resena->comentario) }}</textarea>
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Actualizar Reseña</button>
            <a href="{{ route('admin.resenas.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
@endsection