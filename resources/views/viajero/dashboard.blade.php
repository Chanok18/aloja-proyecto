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
    
    <!-- Estadísticas del viajero -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Mis Reservas</h3>
            <p>{{ \App\Models\Reserva::where('id_usuario', Auth::id())->count() }}</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>Reservas Activas</h3>
            <p>{{ \App\Models\Reserva::where('id_usuario', Auth::id())->whereIn('estado', ['pendiente', 'confirmada'])->count() }}</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h3>Total Gastado</h3>
            <p>S/. {{ number_format(\App\Models\Reserva::where('id_usuario', Auth::id())->where('estado', 'confirmada')->sum('total'), 2) }}</p>
        </div>
    </div>

    <h3 style="margin-top: 30px; margin-bottom: 15px;">Mis Últimas Reservas</h3>
    
    @php
        $reservasRecientes = \App\Models\Reserva::where('id_usuario', Auth::id())
            ->with('hospedaje')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
    @endphp

    @if($reservasRecientes->count() > 0)
        <div style="background: white; border-radius: 8px; padding: 20px;">
            @foreach($reservasRecientes as $reserva)
                <div style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong>{{ $reserva->hospedaje->titulo }}</strong>
                        <div style="color: #666; font-size: 14px;">
                            {{ $reserva->fecha_inicio->format('d/m/Y') }} - {{ $reserva->fecha_fin->format('d/m/Y') }}
                        </div>
                    </div>
                    <div>
                        @if($reserva->estado == 'confirmada')
                            <span style="background: #d1fae5; color: #065f46; padding: 5px 12px; border-radius: 20px; font-size: 12px;">
                                ✅ Confirmada
                            </span>
                        @elseif($reserva->estado == 'pendiente')
                            <span style="background: #fef3c7; color: #92400e; padding: 5px 12px; border-radius: 20px; font-size: 12px;">
                                ⏳ Pendiente
                            </span>
                        @else
                            <span style="background: #fee2e2; color: #991b1b; padding: 5px 12px; border-radius: 20px; font-size: 12px;">
                                ❌ {{ ucfirst($reserva->estado) }}
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p style="color: #666;">No tienes reservas aún. ¡Explora y reserva tu primer hospedaje!</p>
    @endif
    
    <div style="margin-top: 30px;">
        <h3 style="margin-bottom: 15px;">Acciones Rápidas</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('home') }}" class="btn btn-primary">🔍 Buscar Hospedajes</a>
            <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-primary">📋 Ver Todas Mis Reservas</a>
        </div>
    </div>
@endsection