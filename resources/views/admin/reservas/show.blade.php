@extends('layouts.app-dashboard')

@section('title', 'Ver Reserva')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Detalle de la Reserva')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}" class="active">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
@endsection

@section('content')
    <div style="margin-bottom: 20px; display: flex; gap: 10px;">
        <a href="{{ route('admin.reservas.index') }}" class="btn btn-primary">← Volver a la lista</a>
        <a href="{{ route('admin.reservas.edit', $reserva->id_reserva) }}" class="btn btn-primary">✏️ Editar</a>
    </div>

    <div style="max-width: 900px;">
        <h2 style="margin-bottom: 30px;">Reserva #{{ $reserva->id_reserva }}</h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            <!-- Información del Usuario -->
            <div>
                <h3 style="margin-bottom: 15px; color: #1e3a8a;">Usuario/Huésped</h3>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin-bottom: 10px;"><strong>Nombre:</strong> {{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }}</p>
                    <p style="margin-bottom: 10px;"><strong>Correo:</strong> {{ $reserva->usuario->correo }}</p>
                    <p style="margin-bottom: 10px;"><strong>Teléfono:</strong> {{ $reserva->usuario->telefono ?? 'No registrado' }}</p>
                </div>
            </div>

            <!-- Información del Hospedaje -->
            <div>
                <h3 style="margin-bottom: 15px; color: #1e3a8a;">Hospedaje</h3>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin-bottom: 10px;"><strong>Título:</strong> {{ $reserva->hospedaje->titulo }}</p>
                    <p style="margin-bottom: 10px;"><strong>Ubicación:</strong> {{ $reserva->hospedaje->ubicacion }}</p>
                    <p style="margin-bottom: 10px;"><strong>Precio/Noche:</strong> S/. {{ number_format($reserva->hospedaje->precio, 2) }}</p>
                    <p style="margin-bottom: 10px;"><strong>Anfitrión:</strong> {{ $reserva->hospedaje->anfitrion->nombre }}</p>
                </div>
            </div>
        </div>

        <!-- Detalles de la Reserva -->
        <div style="margin-bottom: 30px;">
            <h3 style="margin-bottom: 15px; color: #1e3a8a;">Detalles de la Reserva</h3>
            <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <p><strong>Fecha de Inicio:</strong> {{ $reserva->fecha_inicio->format('d/m/Y') }}</p>
                    <p><strong>Fecha de Fin:</strong> {{ $reserva->fecha_fin->format('d/m/Y') }}</p>
                    <p><strong>Noches:</strong> {{ $reserva->diasReservados() }} noches</p>
                    <p><strong>Total:</strong> S/. {{ number_format($reserva->total, 2) }}</p>
                    <p>
                        <strong>Estado:</strong> 
                        @if($reserva->estado === 'pendiente')
                            <span class="badge badge-warning">Pendiente</span>
                        @elseif($reserva->estado === 'confirmada')
                            <span class="badge badge-success">Confirmada</span>
                        @elseif($reserva->estado === 'completada')
                            <span class="badge badge-success">Completada</span>
                        @else
                            <span class="badge badge-danger">Cancelada</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Información de Pago -->
        @if($reserva->pago)
            <div style="margin-bottom: 30px;">
                <h3 style="margin-bottom: 15px; color: #1e3a8a;">Información de Pago</h3>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin-bottom: 10px;"><strong>Método:</strong> {{ ucfirst($reserva->pago->metodo) }}</p>
                    <p style="margin-bottom: 10px;"><strong>Monto:</strong> S/. {{ number_format($reserva->pago->monto, 2) }}</p>
                    <p style="margin-bottom: 10px;"><strong>Estado:</strong> {{ ucfirst($reserva->pago->estado_pago) }}</p>
                    <p style="margin-bottom: 10px;"><strong>Fecha:</strong> {{ $reserva->pago->fecha_pago->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        @else
            <div style="margin-bottom: 30px;">
                <h3 style="margin-bottom: 15px; color: #1e3a8a;">Información de Pago</h3>
                <div style="background: #fff3cd; color: #856404; padding: 20px; border-radius: 8px;">
                    ⚠️ No hay pago registrado para esta reserva
                </div>
            </div>
        @endif

        <!-- Reseña -->
        @if($reserva->resena)
            <div style="margin-bottom: 30px;">
                <h3 style="margin-bottom: 15px; color: #1e3a8a;">Reseña del Huésped</h3>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin-bottom: 10px;"><strong>Calificación:</strong> {{ $reserva->resena->calificacion }} ⭐</p>
                    <p style="margin-bottom: 10px;"><strong>Comentario:</strong></p>
                    <p>{{ $reserva->resena->comentario ?? 'Sin comentario' }}</p>
                </div>
            </div>
        @endif

        <!-- Fechas del sistema -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #666; font-size: 14px;">
            <p><strong>Reserva creada:</strong> {{ $reserva->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Última actualización:</strong> {{ $reserva->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
@endsection