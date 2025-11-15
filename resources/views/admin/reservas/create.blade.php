@extends('layouts.app-dashboard')

@section('title', 'Crear Reserva')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Crear Nueva Reserva')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}" class="active">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
@endsection

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.reservas.index') }}" class="btn btn-primary">← Volver a la lista</a>
    </div>

    <h2 style="margin-bottom: 30px;">Crear Nueva Reserva</h2>

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

    <form action="{{ route('admin.reservas.store') }}" method="POST" style="max-width: 800px;">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <!-- Usuario -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Usuario/Viajero *</label>
                <select name="id_usuario" required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
                    <option value="">Seleccionar usuario</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id_usuario }}" {{ old('id_usuario') == $usuario->id_usuario ? 'selected' : '' }}>
                            {{ $usuario->nombre }} {{ $usuario->apellido }} ({{ $usuario->correo }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Hospedaje -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Hospedaje *</label>
                <select name="id_hospedaje" required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
                    <option value="">Seleccionar hospedaje</option>
                    @foreach($hospedajes as $hospedaje)
                        <option value="{{ $hospedaje->id_hospedaje }}" {{ old('id_hospedaje') == $hospedaje->id_hospedaje ? 'selected' : '' }}>
                            {{ $hospedaje->titulo }} - S/. {{ $hospedaje->precio }}/noche
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha Inicio -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha de Inicio *</label>
                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            <!-- Fecha Fin -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha de Fin *</label>
                <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" required
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            <!-- Total -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Total (S/.) *</label>
                <input type="number" name="total" value="{{ old('total') }}" required min="0" step="0.01"
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            <!-- Estado -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Estado *</label>
                <select name="estado" required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="confirmada" {{ old('estado') == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                    <option value="completada" {{ old('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                    <option value="cancelada" {{ old('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Guardar Reserva</button>
            <a href="{{ route('admin.reservas.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
@endsection