@extends('layouts.app-dashboard')

@section('title', 'Dashboard Viajero')
@section('role-name', 'Panel Viajero')
@section('page-title', 'Mi Panel de Viajero')
@section('page-description', 'Gestiona tus reservas y explora nuevos hospedajes')

@section('sidebar-menu')
    <a href="{{ route('viajero.dashboard') }}" class="active">
        📊 Dashboard
    </a>
    <a href="{{ route('home') }}">
        🔍 Buscar Hospedajes
    </a>
    <a href="{{ route('reservas.mis-reservas') }}">
        📅 Mis Reservas
    </a>
@endsection

@section('content')
    @php
        // Estadísticas del viajero
        $totalReservas = \App\Models\Reserva::where('id_usuario', Auth::id())->count();
        
        $reservasPendientes = \App\Models\Reserva::where('id_usuario', Auth::id())
            ->where('estado', 'pendiente')
            ->count();
        
        $reservasConfirmadas = \App\Models\Reserva::where('id_usuario', Auth::id())
            ->where('estado', 'confirmada')
            ->count();
        
        $reservasCanceladas = \App\Models\Reserva::where('id_usuario', Auth::id())
            ->where('estado', 'cancelada')
            ->count();
        
        $reservasCompletadas = \App\Models\Reserva::where('id_usuario', Auth::id())
            ->where('estado', 'completada')
            ->count();
        
        // Total gastado (solo en reservas confirmadas y completadas)
        $totalGastado = \App\Models\Reserva::where('id_usuario', Auth::id())
            ->whereIn('estado', ['confirmada', 'completada'])
            ->sum('total');
        
        // Próximas reservas (confirmadas con fecha futura)
        $proximasReservas = \App\Models\Reserva::where('id_usuario', Auth::id())
            ->where('estado', 'confirmada')
            ->where('fecha_inicio', '>=', today())
            ->count();
        
        // Últimas 5 reservas
        $reservasRecientes = \App\Models\Reserva::where('id_usuario', Auth::id())
            ->with('hospedaje')
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
            @if($totalReservas > 0)
                Tienes {{ $totalReservas }} {{ $totalReservas == 1 ? 'reserva' : 'reservas' }} registradas. 
                @if($proximasReservas > 0)
                    🎉 ¡Tienes {{ $proximasReservas }} {{ $proximasReservas == 1 ? 'viaje próximo' : 'viajes próximos' }}!
                @else
                    Explora nuevos destinos para tu próximo viaje.
                @endif
            @else
                ¡Es momento de planear tu próxima aventura! Explora nuestros hospedajes disponibles.
            @endif
        </p>
        <a href="{{ route('home') }}" class="btn" style="background: white; color: #764ba2;">
            🔍 Explorar Hospedajes
        </a>
    </div>

    <!-- ESTADÍSTICAS -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <h3>Mis Reservas</h3>
            <p>{{ number_format($totalReservas) }}</p>
            <small>
                ⏳ {{ $reservasPendientes }} Pendientes | ✅ {{ $reservasConfirmadas }} Confirmadas
            </small>
        </div>

        <div class="stat-card purple">
            <h3>Próximas Reservas</h3>
            <p>{{ number_format($proximasReservas) }}</p>
            <small>
                Reservas confirmadas próximas a viajar
            </small>
        </div>

        <div class="stat-card cyan">
            <h3>Total Gastado</h3>
            <p>S/. {{ number_format($totalGastado, 0) }}</p>
            <small>
                En reservas confirmadas y completadas
            </small>
        </div>

        <div class="stat-card green">
            <h3>Historial</h3>
            <p>{{ number_format($reservasCompletadas) }}</p>
            <small>
                ✅ Completadas | ❌ {{ $reservasCanceladas }} Canceladas
            </small>
        </div>
    </div>

    <!-- MIS RESERVAS -->
    <div class="content-box">
        <div class="section-header">
            <h3 class="section-title">📅 Mis Últimas Reservas</h3>
            @if($totalReservas > 5)
                <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-primary">
                    Ver todas ({{ $totalReservas }})
                </a>
            @endif
        </div>

        @if($reservasRecientes->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Hospedaje</th>
                            <th>Ubicación</th>
                            <th>Fechas</th>
                            <th>Huéspedes</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservasRecientes as $reserva)
                            <tr>
                                <td>
                                    <strong>{{ $reserva->hospedaje->titulo }}</strong>
                                    @if($reserva->hospedaje->fotoPrincipal())
                                        <br>
                                        <img src="{{ $reserva->hospedaje->urlFotoPrincipal() }}" 
                                             alt="{{ $reserva->hospedaje->titulo }}" 
                                             style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px; margin-top: 6px;">
                                    @endif
                                </td>
                                <td>
                                    <span style="display: flex; align-items: center; gap: 4px;">
                                        📍 {{ $reserva->hospedaje->ubicacion }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $reserva->fecha_inicio->format('d/m/Y') }}</strong>
                                    <br>
                                    <small style="color: #9CA3AF;">
                                        hasta {{ $reserva->fecha_fin->format('d/m/Y') }}
                                        ({{ $reserva->diasReservados() }} {{ $reserva->diasReservados() == 1 ? 'noche' : 'noches' }})
                                    </small>
                                </td>
                                <td>
                                    {{ $reserva->num_huespedes }} 
                                    {{ $reserva->num_huespedes == 1 ? 'persona' : 'personas' }}
                                </td>
                                <td>
                                    <strong style="color: #2B4F9B; font-size: 15px;">
                                        S/. {{ number_format($reserva->total, 2) }}
                                    </strong>
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
                                    <br>
                                    <small style="color: #9CA3AF; font-size: 11px;">
                                        {{ $reserva->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($totalReservas > 5)
                <div style="text-align: center; margin-top: 24px;">
                    <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-primary">
                        Ver todas mis reservas ({{ $totalReservas }})
                    </a>
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">🏖️</div>
                <h3>¡No tienes reservas aún!</h3>
                <p>Explora nuestros hospedajes y reserva tu próxima aventura</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    🔍 Explorar Hospedajes
                </a>
            </div>
        @endif
    </div>

    <!-- PRÓXIMAS RESERVAS (si existen) -->
    @if($proximasReservas > 0)
        @php
            $misProximasReservas = \App\Models\Reserva::where('id_usuario', Auth::id())
                ->where('estado', 'confirmada')
                ->where('fecha_inicio', '>=', today())
                ->with('hospedaje')
                ->orderBy('fecha_inicio', 'asc')
                ->take(3)
                ->get();
        @endphp

        <div class="content-box" style="margin-top: 30px; background: linear-gradient(135deg, #F0FDF4 0%, #DCFCE7 100%); border: 2px solid #10B981;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                <div style="width: 48px; height: 48px; background: #10B981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                    ✈️
                </div>
                <div>
                    <h3 style="font-size: 20px; font-weight: 700; color: #065F46; margin-bottom: 4px;">
                        ¡Tienes viajes próximos!
                    </h3>
                    <p style="font-size: 14px; color: #047857; margin: 0;">
                        Prepara tu equipaje, la aventura está cerca
                    </p>
                </div>
            </div>

            <div style="display: grid; gap: 16px;">
                @foreach($misProximasReservas as $proxima)
                    <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #D1FAE5; display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; gap: 16px; align-items: center;">
                            @if($proxima->hospedaje->fotoPrincipal())
                                <img src="{{ $proxima->hospedaje->urlFotoPrincipal() }}" 
                                     alt="{{ $proxima->hospedaje->titulo }}"
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                            @else
                                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 36px;">
                                    🏠
                                </div>
                            @endif
                            
                            <div>
                                <h4 style="font-size: 16px; font-weight: 700; color: #1A1A1A; margin-bottom: 6px;">
                                    {{ $proxima->hospedaje->titulo }}
                                </h4>
                                <p style="font-size: 14px; color: #6B7280; margin-bottom: 4px;">
                                    📍 {{ $proxima->hospedaje->ubicacion }}
                                </p>
                                <p style="font-size: 14px; color: #2B4F9B; font-weight: 600; margin: 0;">
                                    📅 {{ $proxima->fecha_inicio->format('d/m/Y') }} - {{ $proxima->fecha_fin->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>

                        <div style="text-align: right;">
                            @php
                                $diasRestantes = today()->diffInDays($proxima->fecha_inicio, false);
                            @endphp
                            <div style="background: #FEF3C7; color: #92400E; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                                @if($diasRestantes == 0)
                                    ¡Hoy! 🎉
                                @elseif($diasRestantes == 1)
                                    Mañana
                                @else
                                    En {{ $diasRestantes }} días
                                @endif
                            </div>
                            <p style="font-size: 15px; color: #1A1A1A; font-weight: 700; margin: 0;">
                                S/. {{ number_format($proxima->total, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- ACCIONES RÁPIDAS -->
    <div style="margin-top: 30px;">
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: #1A1A1A;">⚡ Acciones Rápidas</h3>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="btn btn-primary">
                🔍 Buscar Hospedajes
            </a>
            <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-primary">
                📋 Ver Todas Mis Reservas
            </a>
            @if($totalReservas > 0)
                <a href="{{ route('hospedajes.publico.index') }}" class="btn btn-secondary">
                    🏠 Explorar Más Destinos
                </a>
            @endif
        </div>
    </div>
@endsection