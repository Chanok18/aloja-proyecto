@extends('layouts.app-dashboard')

@section('title', 'Ver Pago')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Detalle del Pago')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}" class="active">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
@endsection

@section('content')
    <div style="margin-bottom: 20px; display: flex; gap: 10px;">
        <a href="{{ route('admin.pagos.index') }}" class="btn btn-primary">← Volver a la lista</a>
        <a href="{{ route('admin.pagos.edit', $pago->id_pago) }}" class="btn btn-primary">✏️ Editar</a>
    </div>

    <div style="max-width: 900px;">
        <h2 style="margin-bottom: 30px;">Pago #{{ $pago->id_pago }}</h2>

        <!-- Estado del Pago -->
        <div style="margin-bottom: 30px;">
            @if($pago->estado_pago === 'completado')
                <span class="badge badge-success" style="font-size: 18px; padding: 10px 20px;">✅ Pago Completado</span>
            @elseif($pago->estado_pago === 'pendiente')
                <span class="badge badge-warning" style="font-size: 18px; padding: 10px 20px;">⏳ Pago Pendiente</span>
            @elseif($pago->estado_pago === 'fallido')
                <span class="badge badge-danger" style="font-size: 18px; padding: 10px 20px;">❌ Pago Fallido</span>
            @else
                <span class="badge badge-warning" style="font-size: 18px; padding: 10px 20px;">💸 Reembolsado</span>
            @endif
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            <!-- Información del Pago -->
            <div>
                <h3 style="margin-bottom: 15px; color: #1e3a8a;">Información del Pago</h3>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin-bottom: 10px;"><strong>Monto:</strong> S/. {{ number_format($pago->monto, 2) }}</p>
                    <p style="margin-bottom: 10px;"><strong>Método:</strong> {{ ucfirst($pago->metodo) }}</p>
                    <p style="margin-bottom: 10px;"><strong>Fecha:</strong> {{ $pago->fecha_pago->format('d/m/Y H:i') }}</p>
                    <p style="margin-bottom: 10px;"><strong>Referencia:</strong> {{ $pago->referencia_pago ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Información de la Reserva -->
            <div>
                <h3 style="margin-bottom: 15px; color: #1e3a8a;">Reserva Asociada</h3>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin-bottom: 10px;"><strong>Reserva:</strong> #{{ $pago->reserva->id_reserva }}</p>
                    <p style="margin-bottom: 10px;"><strong>Usuario:</strong> {{ $pago->reserva->usuario->nombre }} {{ $pago->reserva->usuario->apellido }}</p>
                    <p style="margin-bottom: 10px;"><strong>Hospedaje:</strong> {{ $pago->reserva->hospedaje->titulo }}</p>
                    <p style="margin-bottom: 10px;"><strong>Fechas:</strong> {{ $pago->reserva->fecha_inicio->format('d/m/Y') }} - {{ $pago->reserva->fecha_fin->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Botón para ver reserva -->
        <div style="margin-top: 30px;">
            <a href="{{ route('admin.reservas.show', $pago->reserva->id_reserva) }}" class="btn btn-primary">
                Ver Detalles de la Reserva →
            </a>
        </div>
    </div>
@endsection