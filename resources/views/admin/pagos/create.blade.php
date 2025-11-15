@extends('layouts.app-dashboard')

@section('title', 'Registrar Pago')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Registrar Nuevo Pago')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}" class="active">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
@endsection

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.pagos.index') }}" class="btn btn-primary">← Volver a la lista</a>
    </div>

    <h2 style="margin-bottom: 30px;">Registrar Nuevo Pago</h2>

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

    <form action="{{ route('admin.pagos.store') }}" method="POST" style="max-width: 800px;">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <!-- Reserva -->
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Reserva *</label>
                <select name="id_reserva" required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
                    <option value="">Seleccionar reserva</option>
                    @forelse($reservas as $reserva)
                        <option value="{{ $reserva->id_reserva }}" {{ old('id_reserva') == $reserva->id_reserva ? 'selected' : '' }}>
                            #{{ $reserva->id_reserva }} - {{ $reserva->hospedaje->titulo }} - {{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }} (S/. {{ $reserva->total }})
                        </option>
                    @empty
                        <option value="">No hay reservas sin pago</option>
                    @endforelse
                </select>
                <small style="color: #666;">Solo se muestran reservas confirmadas sin pago</small>
            </div>

            <!-- Monto -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Monto (S/.) *</label>
                <input type="number" name="monto" value="{{ old('monto') }}" required min="0" step="0.01"
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>

            <!-- Método de Pago -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Método de Pago *</label>
                <select name="metodo" required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
                    <option value="">Seleccionar método</option>
                    <option value="tarjeta" {{ old('metodo') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                    <option value="yape" {{ old('metodo') == 'yape' ? 'selected' : '' }}>Yape</option>
                    <option value="plin" {{ old('metodo') == 'plin' ? 'selected' : '' }}>Plin</option>
                    <option value="paypal" {{ old('metodo') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                    <option value="transferencia" {{ old('metodo') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                </select>
            </div>

            <!-- Estado del Pago -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Estado del Pago *</label>
                <select name="estado_pago" required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
                    <option value="pendiente" {{ old('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="completado" {{ old('estado_pago') == 'completado' ? 'selected' : '' }}>Completado</option>
                    <option value="fallido" {{ old('estado_pago') == 'fallido' ? 'selected' : '' }}>Fallido</option>
                    <option value="reembolsado" {{ old('estado_pago') == 'reembolsado' ? 'selected' : '' }}>Reembolsado</option>
                </select>
            </div>

            <!-- Referencia de Pago -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Referencia/ID de Transacción</label>
                <input type="text" name="referencia_pago" value="{{ old('referencia_pago') }}" maxlength="100"
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;"
                       placeholder="Ej: TXN-123456">
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Registrar Pago</button>
            <a href="{{ route('admin.pagos.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
@endsection