@extends('layouts.app-dashboard')

@section('title', 'Dashboard Anfitrión')
@section('role-name', 'Panel de Anfitrión')
@section('page-title', 'Dashboard Anfitrión')

@section('sidebar-menu')
    <a href="{{ route('anfitrion.dashboard') }}" class="active">📊 Dashboard</a>
    <a href="{{ route('anfitrion.hospedajes.index') }}">🏠 Mis Hospedajes</a>
    <a href="{{ route('anfitrion.reservas.index') }}">📅 Reservas</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Bienvenido, {{ Auth::user()->nombre }}</h2>
    
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
    
    <!-- Estadísticas del anfitrión -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Mis Hospedajes</h3>
            <p>{{ $totalMisHospedajes }}</p>
            <small style="font-size: 12px; opacity: 0.8;">
                ✅ {{ $misHospedajesActivos }} Activos | ❌ {{ $misHospedajesInactivos }} Inactivos
            </small>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>Reservas Totales</h3>
            <p>{{ $totalReservas }}</p>
            <small style="font-size: 12px; opacity: 0.8;">
                🔴 {{ $reservasActivas }} Activas | ✅ {{ $reservasConfirmadas }} Confirmadas
            </small>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h3>Ganancias</h3>
            <p>S/. {{ number_format($gananciasTotales, 2) }}</p>
            <small style="font-size: 12px; opacity: 0.8;">
                Este mes: S/. {{ number_format($gananciasMes, 2) }}
            </small>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>Calificación Promedio</h3>
            <p>{{ number_format($calificacionPromedio, 1) }} ⭐</p>
            <small style="font-size: 12px; opacity: 0.8;">
                Basado en tus reseñas
            </small>
        </div>
    </div>

    <!-- Últimas Reservas en mis propiedades -->
    <h3 style="margin-top: 30px; margin-bottom: 15px;">Reservas Recientes en Mis Propiedades</h3>
    
    @if($ultimasReservas->count() > 0)
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
                        <td>{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }}</td>
                        <td>{{ $reserva->hospedaje->titulo }}</td>
                        <td>{{ $reserva->fecha_inicio->format('d/m/Y') }} - {{ $reserva->fecha_fin->format('d/m/Y') }}</td>
                        <td>{{ $reserva->num_huespedes }} persona(s)</td>
                        <td>S/. {{ number_format($reserva->total, 2) }}</td>
                        <td>
                            @if($reserva->estado == 'confirmada')
                                <span class="badge badge-success">✅ Confirmada</span>
                            @elseif($reserva->estado == 'pendiente')
                                <span class="badge badge-warning">⏳ Pendiente</span>
                            @elseif($reserva->estado == 'cancelada')
                                <span class="badge badge-danger">❌ Cancelada</span>
                            @else
                                <span class="badge badge-success">✅ Completada</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color: #666;">No hay reservas recientes en tus propiedades.</p>
    @endif
    
    <!-- Acciones Rápidas -->
    <div style="margin-top: 30px;">
        <h3 style="margin-bottom: 15px;">Acciones Rápidas</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('anfitrion.hospedajes.create') }}" class="btn btn-primary">+ Publicar Nuevo Hospedaje</a>
            <a href="{{ route('anfitrion.hospedajes.index') }}" class="btn btn-primary">🏠 Ver Mis Hospedajes</a>
            <a href="{{ route('anfitrion.reservas.index') }}" class="btn btn-primary">📅 Ver Todas las Reservas</a>
        </div>
    </div>
@endsection