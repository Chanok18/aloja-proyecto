@extends('layouts.app-dashboard')

@section('title', 'Dashboard Viajero')
@section('role-name', 'Panel de Viajero')
@section('page-title', 'Dashboard Viajero')

@section('sidebar-menu')
    <a href="{{ route('viajero.dashboard') }}" class="active">📊 Dashboard</a>
    <a href="{{ route('home') }}">🔍 Buscar Hospedajes</a>
    <a href="{{ route('reservas.mis-reservas') }}">📅 Mis Reservas</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Bienvenido, {{ Auth::user()->nombre }}</h2>
    
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
    
    <!-- Estadísticas del viajero -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Mis Reservas</h3>
            <p>{{ $totalReservas }}</p>
            <small style="font-size: 12px; opacity: 0.8;">
                ⏳ {{ $reservasPendientes }} Pendientes | ✅ {{ $reservasConfirmadas }} Confirmadas
            </small>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>Próximas Reservas</h3>
            <p>{{ $proximasReservas }}</p>
            <small style="font-size: 12px; opacity: 0.8;">
                Reservas confirmadas próximas
            </small>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h3>Total Gastado</h3>
            <p>S/. {{ number_format($totalGastado, 2) }}</p>
            <small style="font-size: 12px; opacity: 0.8;">
                En reservas confirmadas y completadas
            </small>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>Historial</h3>
            <p>{{ $reservasCompletadas }}</p>
            <small style="font-size: 12px; opacity: 0.8;">
                Reservas completadas | ❌ {{ $reservasCanceladas }} Canceladas
            </small>
        </div>
    </div>

    <!-- Mis Últimas Reservas -->
    <h3 style="margin-top: 30px; margin-bottom: 15px;">Mis Últimas Reservas</h3>
    
    @if($reservasRecientes->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Hospedaje</th>
                    <th>Ubicación</th>
                    <th>Fechas</th>
                    <th>Huéspedes</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha Reserva</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservasRecientes as $reserva)
                    <tr>
                        <td>
                            <strong>{{ $reserva->hospedaje->titulo }}</strong>
                        </td>
                        <td>{{ $reserva->hospedaje->ubicacion }}</td>
                        <td>
                            {{ $reserva->fecha_inicio->format('d/m/Y') }} - 
                            {{ $reserva->fecha_fin->format('d/m/Y') }}
                            <br>
                            <small style="color: #666;">
                                ({{ $reserva->diasReservados() }} {{ $reserva->diasReservados() == 1 ? 'noche' : 'noches' }})
                            </small>
                        </td>
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
                        <td>{{ $reserva->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="margin-top: 20px; text-align: center;">
            <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-primary">
                Ver Todas Mis Reservas ({{ $totalReservas }})
            </a>
        </div>
    @else
        <div style="background: #f3f4f6; padding: 40px; text-align: center; border-radius: 8px;">
            <p style="color: #666; font-size: 18px; margin-bottom: 20px;">
                🏖️ ¡No tienes reservas aún!
            </p>
            <p style="color: #999; margin-bottom: 20px;">
                Explora nuestros hospedajes y reserva tu próxima aventura
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                🔍 Explorar Hospedajes
            </a>
        </div>
    @endif
    
    <!-- Acciones Rápidas -->
    <div style="margin-top: 30px;">
        <h3 style="margin-bottom: 15px;">Acciones Rápidas</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('home') }}" class="btn btn-primary">🔍 Buscar Hospedajes</a>
            <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-primary">📋 Ver Todas Mis Reservas</a>
        </div>
    </div>
@endsection