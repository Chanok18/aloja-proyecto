@extends('layouts.app-dashboard')

@section('title', 'Dashboard Anfitrión')
@section('role-name', 'Panel Anfitrión')
@section('page-title', 'Panel de Control Anfitrión')
@section('page-description', 'Gestiona tus hospedajes y reservas')

@section('sidebar-menu')
    <a href="{{ route('anfitrion.dashboard') }}" class="active">
        📊 Dashboard
    </a>
    <a href="{{ route('anfitrion.hospedajes.index') }}">
        🏠 Mis Hospedajes
    </a>
    <a href="{{ route('anfitrion.reservas.index') }}">
        📅 Reservas
    </a>
@endsection

@section('content')
    @php
        // Estadísticas de MIS hospedajes
        $misHospedajes = \App\Models\Hospedaje::where('id_anfitrion', Auth::id());
        $totalMisHospedajes = $misHospedajes->count();
        $misHospedajesActivos = $misHospedajes->where('disponible', true)->count();
        $misHospedajesInactivos = $totalMisHospedajes - $misHospedajesActivos;
        
        // IDs de mis hospedajes para filtrar reservas
        $misHospedajesIds = \App\Models\Hospedaje::where('id_anfitrion', Auth::id())
            ->pluck('id_hospedaje');
        
        // Reservas en MIS hospedajes
        $reservasEnMisHospedajes = \App\Models\Reserva::whereIn('id_hospedaje', $misHospedajesIds);
        $totalReservas = $reservasEnMisHospedajes->count();
        $reservasActivas = $reservasEnMisHospedajes->whereIn('estado', ['pendiente', 'confirmada'])->count();
        $reservasConfirmadas = $reservasEnMisHospedajes->where('estado', 'confirmada')->count();
        
        // Ganancias de MIS hospedajes (solo reservas confirmadas con pago completado)
        $pagosDeReservasConfirmadas = \App\Models\Pago::whereHas('reserva', function($query) use ($misHospedajesIds) {
                $query->whereIn('id_hospedaje', $misHospedajesIds)
                      ->where('estado', 'confirmada');
            })
            ->where('estado_pago', 'completado');
        
        $gananciasTotales = $pagosDeReservasConfirmadas->sum('monto');
        $gananciasMes = $pagosDeReservasConfirmadas
            ->whereMonth('fecha_pago', now()->month)
            ->whereYear('fecha_pago', now()->year)
            ->sum('monto');
        
        // Calificación promedio de MIS hospedajes
        $calificacionPromedio = \App\Models\Resena::whereIn('id_hospedaje', $misHospedajesIds)
            ->avg('calificacion') ?? 0;
        
        // Últimas 5 reservas en MIS hospedajes
        $ultimasReservas = \App\Models\Reserva::whereIn('id_hospedaje', $misHospedajesIds)
            ->with(['usuario', 'hospedaje'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    @endphp

    <!-- MENSAJE DE BIENVENIDA -->
    <div class="content-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; margin-bottom: 30px;">
        <h2 style="font-size: 24px; margin-bottom: 8px;">
            👋 ¡Hola, {{ Auth::user()->nombre }}!
        </h2>
        <p style="font-size: 15px; opacity: 0.95; margin-bottom: 20px;">
            Aquí puedes gestionar tus hospedajes y ver las reservas de tus propiedades
        </p>
        <a href="{{ route('anfitrion.hospedajes.create') }}" class="btn" style="background: white; color: #764ba2;">
            ➕ Publicar Nuevo Hospedaje
        </a>
    </div>

    <!-- ESTADÍSTICAS -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <h3>Mis Hospedajes</h3>
            <p>{{ number_format($totalMisHospedajes) }}</p>
            <small>
                ✅ {{ $misHospedajesActivos }} Activos | ❌ {{ $misHospedajesInactivos }} Inactivos
            </small>
        </div>

        <div class="stat-card purple">
            <h3>Reservas Totales</h3>
            <p>{{ number_format($totalReservas) }}</p>
            <small>
                🔴 {{ $reservasActivas }} Activas | ✅ {{ $reservasConfirmadas }} Confirmadas
            </small>
        </div>

        <div class="stat-card cyan">
            <h3>Ganancias</h3>
            <p>S/. {{ number_format($gananciasTotales, 0) }}</p>
            <small>
                Este mes: <strong>S/. {{ number_format($gananciasMes, 2) }}</strong>
            </small>
        </div>

        <div class="stat-card green">
            <h3>Calificación Promedio</h3>
            <p>{{ number_format($calificacionPromedio, 1) }} ⭐</p>
            <small>
                Basado en reseñas de tus hospedajes
            </small>
        </div>
    </div>

    <!-- RESERVAS RECIENTES -->
    <div class="content-box">
        <div class="section-header">
            <h3 class="section-title">📅 Reservas Recientes en Mis Propiedades</h3>
            <a href="{{ route('anfitrion.reservas.index') }}" class="btn btn-primary">
                Ver todas
            </a>
        </div>

        @if($ultimasReservas->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Viajero</th>
                            <th>Hospedaje</th>
                            <th>Fechas</th>
                            <th>Huéspedes</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ultimasReservas as $reserva)
                            <tr>
                                <td>
                                    <strong>{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }}</strong>
                                    <br>
                                    <small style="color: #9CA3AF;">{{ $reserva->usuario->correo }}</small>
                                </td>
                                <td>
                                    <strong>{{ $reserva->hospedaje->titulo }}</strong>
                                </td>
                                <td>
                                    {{ $reserva->fecha_inicio->format('d/m/Y') }}
                                    <br>
                                    <small style="color: #9CA3AF;">hasta {{ $reserva->fecha_fin->format('d/m/Y') }}</small>
                                </td>
                                <td>{{ $reserva->num_huespedes }} persona(s)</td>
                                <td>
                                    <strong style="color: #2B4F9B;">S/. {{ number_format($reserva->total, 2) }}</strong>
                                </td>
                                <td>
                                    @if($reserva->estado == 'confirmada')
                                        <span class="badge badge-success">✅ Confirmada</span>
                                    @elseif($reserva->estado == 'pendiente')
                                        <span class="badge badge-warning">⏳ Pendiente</span>
                                    @elseif($reserva->estado == 'cancelada')
                                        <span class="badge badge-danger">❌ Cancelada</span>
                                    @else
                                        <span class="badge badge-info">✅ Completada</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📅</div>
                <h3>No hay reservas recientes</h3>
                <p>Las reservas en tus propiedades aparecerán aquí</p>
                <a href="{{ route('anfitrion.hospedajes.create') }}" class="btn btn-primary">
                    ➕ Publicar Hospedaje
                </a>
            </div>
        @endif
    </div>

    <!-- ACCIONES RÁPIDAS -->
    <div style="margin-top: 30px;">
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: #1A1A1A;">⚡ Acciones Rápidas</h3>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('anfitrion.hospedajes.create') }}" class="btn btn-primary">
                ➕ Publicar Nuevo Hospedaje
            </a>
            <a href="{{ route('anfitrion.hospedajes.index') }}" class="btn btn-primary">
                🏠 Ver Mis Hospedajes
            </a>
            <a href="{{ route('anfitrion.reservas.index') }}" class="btn btn-secondary">
                📅 Ver Todas las Reservas
            </a>
        </div>
    </div>
@endsection