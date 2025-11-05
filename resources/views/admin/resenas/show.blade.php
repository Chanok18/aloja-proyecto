@extends('layouts.app-dashboard')

@section('title', 'Ver Reseña')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Detalle de la Reseña')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}" class="active">⭐ Reseñas</a>
    <a href="{{ route('admin.usuarios.index') }}">👥 Usuarios</a>
@endsection

@section('content')
    <div style="margin-bottom: 20px; display: flex; gap: 10px;">
        <a href="{{ route('admin.resenas.index') }}" class="btn btn-primary">← Volver a la lista</a>
        <a href="{{ route('admin.resenas.edit', $resena->id_resena) }}" class="btn btn-primary">✏️ Editar</a>
    </div>

    <div style="max-width: 900px;">
        <h2 style="margin-bottom: 30px;">Reseña #{{ $resena->id_resena }}</h2>

        <!-- Calificación -->
        <div style="margin-bottom: 30px; text-align: center; background: #f9fafb; padding: 30px; border-radius: 8px;">
            <div style="font-size: 48px; color: #f59e0b; margin-bottom: 10px;">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $resena->calificacion)
                        ⭐
                    @else
                        ☆
                    @endif
                @endfor
            </div>
            <p style="font-size: 24px; font-weight: bold; color: #333;">{{ $resena->calificacion }} de 5 estrellas</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            <!-- Usuario -->
            <div>
                <h3 style="margin-bottom: 15px; color: #1e3a8a;">Usuario</h3>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin-bottom: 10px;"><strong>Nombre:</strong> {{ $resena->usuario->nombre }} {{ $resena->usuario->apellido }}</p>
                    <p style="margin-bottom: 10px;"><strong>Correo:</strong> {{ $resena->usuario->correo }}</p>
                </div>
            </div>

            <!-- Hospedaje -->
            <div>
                <h3 style="margin-bottom: 15px; color: #1e3a8a;">Hospedaje</h3>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin-bottom: 10px;"><strong>Título:</strong> {{ $resena->hospedaje->titulo }}</p>
                    <p style="margin-bottom: 10px;"><strong>Ubicación:</strong> {{ $resena->hospedaje->ubicacion }}</p>
                </div>
            </div>
        </div>

        <!-- Comentario -->
        <div style="margin-bottom: 30px;">
            <h3 style="margin-bottom: 15px; color: #1e3a8a;">Comentario</h3>
            <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                <p style="line-height: 1.6;">{{ $resena->comentario ?? 'Sin comentario' }}</p>
            </div>
        </div>

        <!-- Info de la Reserva -->
        <div style="margin-bottom: 30px;">
            <h3 style="margin-bottom: 15px; color: #1e3a8a;">Reserva Asociada</h3>
            <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                <p style="margin-bottom: 10px;"><strong>Reserva:</strong> #{{ $resena->reserva->id_reserva }}</p>
                <p style="margin-bottom: 10px;"><strong>Fechas:</strong> {{ $resena->reserva->fecha_inicio->format('d/m/Y') }} - {{ $resena->reserva->fecha_fin->format('d/m/Y') }}</p>
                <p style="margin-bottom: 10px;"><strong>Total:</strong> S/. {{ number_format($resena->reserva->total, 2) }}</p>
            </div>
        </div>

        <!-- Fecha -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #666; font-size: 14px;">
            <p><strong>Fecha de la reseña:</strong> {{ $resena->fecha_resena->format('d/m/Y H:i') }}</p>
        </div>
    </div>
@endsection
