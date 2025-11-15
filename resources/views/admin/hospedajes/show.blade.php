@extends('layouts.app-dashboard')

@section('title', 'Ver Hospedaje')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Detalle del Hospedaje')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}" class="active">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
    
@endsection

@section('content')
    <div style="margin-bottom: 20px; display: flex; gap: 10px;">
        <a href="{{ route('admin.hospedajes.index') }}" class="btn btn-primary">← Volver a la lista</a>
        <a href="{{ route('admin.hospedajes.edit', $hospedaje->id_hospedaje) }}" class="btn btn-primary">✏️ Editar</a>
    </div>

    <div style="max-width: 900px;">
        <h2 style="margin-bottom: 30px;">{{ $hospedaje->titulo }}</h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            <!-- Información básica -->
            <div>
                <h3 style="margin-bottom: 15px; color: #1e3a8a;">Información Básica</h3>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin-bottom: 10px;"><strong>ID:</strong> #{{ $hospedaje->id_hospedaje }}</p>
                    <p style="margin-bottom: 10px;"><strong>Ubicación:</strong> {{ $hospedaje->ubicacion }}</p>
                    <p style="margin-bottom: 10px;"><strong>Precio:</strong> S/. {{ number_format($hospedaje->precio, 2) }} / noche</p>
                    <p style="margin-bottom: 10px;"><strong>Capacidad:</strong> {{ $hospedaje->capacidad }} personas</p>
                    <p style="margin-bottom: 10px;">
                        <strong>Estado:</strong> 
                        @if($hospedaje->disponible)
                            <span class="badge badge-success">Disponible</span>
                        @else
                            <span class="badge badge-danger">No disponible</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Anfitrión -->
            <div>
                <h3 style="margin-bottom: 15px; color: #1e3a8a;">Anfitrión</h3>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin-bottom: 10px;"><strong>Nombre:</strong> {{ $hospedaje->anfitrion->nombre }} {{ $hospedaje->anfitrion->apellido }}</p>
                    <p style="margin-bottom: 10px;"><strong>Correo:</strong> {{ $hospedaje->anfitrion->correo }}</p>
                    <p style="margin-bottom: 10px;"><strong>Teléfono:</strong> {{ $hospedaje->anfitrion->telefono ?? 'No registrado' }}</p>
                </div>
            </div>
        </div>

        <!-- Descripción -->
        <div style="margin-bottom: 30px;">
            <h3 style="margin-bottom: 15px; color: #1e3a8a;">Descripción</h3>
            <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                <p>{{ $hospedaje->descripcion ?? 'Sin descripción' }}</p>
            </div>
        </div>

        <!-- Amenidades -->
        <div style="margin-bottom: 30px;">
            <h3 style="margin-bottom: 15px; color: #1e3a8a;">Amenidades</h3>
            <div style="background: #f9fafb; padding: 20px; border-radius: 8px; display: flex; gap: 20px;">
                @if($hospedaje->wifi)
                    <span style="padding: 8px 16px; background: #d1fae5; color: #065f46; border-radius: 20px;">
                        ✅ WiFi
                    </span>
                @else
                    <span style="padding: 8px 16px; background: #fee2e2; color: #991b1b; border-radius: 20px;">
                        ❌ WiFi
                    </span>
                @endif

                @if($hospedaje->cocina)
                    <span style="padding: 8px 16px; background: #d1fae5; color: #065f46; border-radius: 20px;">
                        ✅ Cocina
                    </span>
                @else
                    <span style="padding: 8px 16px; background: #fee2e2; color: #991b1b; border-radius: 20px;">
                        ❌ Cocina
                    </span>
                @endif

                @if($hospedaje->estacionamiento)
                    <span style="padding: 8px 16px; background: #d1fae5; color: #065f46; border-radius: 20px;">
                        ✅ Estacionamiento
                    </span>
                @else
                    <span style="padding: 8px 16px; background: #fee2e2; color: #991b1b; border-radius: 20px;">
                        ❌ Estacionamiento
                    </span>
                @endif
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Reservas</h3>
                <p>{{ $hospedaje->reservas->count() }}</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>Calificación Promedio</h3>
                <p>{{ number_format($hospedaje->promedioCalificacion() ?? 0, 1) }} ⭐</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>Total Reseñas</h3>
                <p>{{ $hospedaje->totalResenas() }}</p>
            </div>
        </div>

        <!-- Fechas -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #666; font-size: 14px;">
            <p><strong>Creado:</strong> {{ $hospedaje->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Última actualización:</strong> {{ $hospedaje->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
@endsection
