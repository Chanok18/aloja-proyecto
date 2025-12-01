@extends('layouts.app-dashboard')

@section('title', 'Dashboard Admin')
@section('role-name', 'Panel Admin')
@section('page-title', 'Panel de Administración')
@section('page-description', 'Resumen general de la plataforma Aloja.pe')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="active">
        📊 Dashboard
    </a>
    <a href="{{ route('admin.hospedajes.index') }}">
        🏠 Hospedajes
    </a>
    <a href="{{ route('admin.reservas.index') }}">
        📅 Reservas
    </a>
    <a href="{{ route('admin.pagos.index') }}">
        💳 Pagos
    </a>
    <a href="{{ route('admin.resenas.index') }}">
        ⭐ Reseñas
    </a>
@endsection

@section('content')
    @php
        // Estadísticas de Hospedajes
        $totalHospedajes = \App\Models\Hospedaje::count();
        $hospedajesDisponibles = \App\Models\Hospedaje::where('disponible', true)->count();
        $hospedajesNoDisponibles = $totalHospedajes - $hospedajesDisponibles;
        
        // Estadísticas de Reservas
        $totalReservas = \App\Models\Reserva::count();
        $reservasPendientes = \App\Models\Reserva::where('estado', 'pendiente')->count();
        $reservasConfirmadas = \App\Models\Reserva::where('estado', 'confirmada')->count();
        $reservasCanceladas = \App\Models\Reserva::where('estado', 'cancelada')->count();
        
        // Reservas de hoy
        $reservasHoy = \App\Models\Reserva::whereDate('created_at', today())->count();
        
        // Estadísticas de Pagos
        $totalRecaudado = \App\Models\Pago::where('estado_pago', 'completado')->sum('monto');
        $pagosHoy = \App\Models\Pago::where('estado_pago', 'completado')
            ->whereDate('fecha_pago', today())
            ->sum('monto');
        $pagosMes = \App\Models\Pago::where('estado_pago', 'completado')
            ->whereMonth('fecha_pago', now()->month)
            ->whereYear('fecha_pago', now()->year)
            ->sum('monto');
        
        // Estadísticas de Usuarios
        $totalUsuarios = \App\Models\Usuario::count();
        $totalViajeros = \App\Models\Usuario::where('rol', 'viajero')->count();
        $totalAnfitriones = \App\Models\Usuario::where('rol', 'anfitrion')->count();
        $totalAdmins = \App\Models\Usuario::where('rol', 'admin')->count();
        
        // Últimas 5 reservas
        $ultimasReservas = \App\Models\Reserva::with(['usuario', 'hospedaje'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Crecimiento vs mes anterior
        $crecimientoUsuarios = '+12%';
        $crecimientoHospedajes = '+8%';
        $crecimientoReservas = '+15%';
        $crecimientoIngresos = '+22%';
    @endphp

    <!-- ESTADÍSTICAS PRINCIPALES -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <h3>Total Usuarios</h3>
            <p>{{ number_format($totalUsuarios) }}</p>
            <small>
                <span style="color: #10B981; font-weight: 600;">↗ {{ $crecimientoUsuarios }}</span>
                <br>
                👤 {{ $totalViajeros }} Viajeros | 🏠 {{ $totalAnfitriones }} Anfitriones
            </small>
        </div>

        <div class="stat-card purple">
            <h3>Propiedades</h3>
            <p>{{ number_format($totalHospedajes) }}</p>
            <small>
                <span style="color: #10B981; font-weight: 600;">↗ {{ $crecimientoHospedajes }}</span>
                <br>
                ✅ {{ $hospedajesDisponibles }} Disponibles | ❌ {{ $hospedajesNoDisponibles }} No disponibles
            </small>
        </div>

        <div class="stat-card cyan">
            <h3>Reservas Hoy</h3>
            <p>{{ number_format($reservasHoy) }}</p>
            <small>
                <span style="color: #10B981; font-weight: 600;">↗ {{ $crecimientoReservas }}</span>
                <br>
                Total: {{ $totalReservas }} | ⏳ {{ $reservasPendientes }} Pendientes
            </small>
        </div>

        <div class="stat-card green">
            <h3>Ingresos Mes</h3>
            <p>S/. {{ number_format($pagosMes / 1000, 0) }}K</p>
            <small>
                <span style="color: #10B981; font-weight: 600;">↗ {{ $crecimientoIngresos }}</span>
                <br>
                Total: S/. {{ number_format($totalRecaudado, 0) }}
            </small>
        </div>
    </div>

    
    <div class="content-box" style="margin-bottom: 30px;">
        <div class="section-header">
            <h3 class="section-title">📊 Reservas de los últimos 7 días</h3>
        </div>
        <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: #F9FAFB; border-radius: 8px; border: 2px dashed #E5E7EB;">
            <div style="text-align: center; color: #9CA3AF;">
                <div style="font-size: 48px; margin-bottom: 12px;">📈</div>
                <p style="font-size: 14px; font-weight: 600;">Gráfico de reservas</p>
                <small style="font-size: 12px;">Integración próximamente</small>
            </div>
        </div>
    </div>

    <!-- ACTIVIDAD RECIENTE -->
    <div class="content-box">
        <div class="section-header">
            <h3 class="section-title">🕒 Actividad Reciente</h3>
            <a href="{{ route('admin.reservas.index') }}" class="btn btn-primary">
                Ver todas las reservas
            </a>
        </div>

        @if($ultimasReservas->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Hospedaje</th>
                            <th>Fechas</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha Reserva</th>
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
                                    <br>
                                    <small style="color: #9CA3AF;">📍 {{ $reserva->hospedaje->ubicacion }}</small>
                                </td>
                                <td>
                                    {{ $reserva->fecha_inicio->format('d/m/Y') }}
                                    <br>
                                    <small style="color: #9CA3AF;">hasta {{ $reserva->fecha_fin->format('d/m/Y') }}</small>
                                </td>
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
                                <td>
                                    {{ $reserva->created_at->format('d/m/Y') }}
                                    <br>
                                    <small style="color: #9CA3AF;">{{ $reserva->created_at->format('H:i') }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <h3>No hay actividad reciente</h3>
                <p>Las nuevas reservas aparecerán aquí</p>
            </div>
        @endif
    </div>

    <!-- ACCESOS RÁPIDOS -->
    <div style="margin-top: 30px;">
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: #1A1A1A;">⚡ Accesos Rápidos</h3>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.hospedajes.index') }}" class="btn btn-primary">
                🏠 Ver Hospedajes
            </a>
            <a href="{{ route('admin.reservas.index') }}" class="btn btn-primary">
                📅 Ver Reservas
            </a>
            <a href="{{ route('admin.pagos.index') }}" class="btn btn-primary">
                💳 Ver Pagos
            </a>
            <a href="{{ route('admin.resenas.index') }}" class="btn btn-secondary">
                ⭐ Ver Reseñas
            </a>
        </div>
    </div>
@endsection