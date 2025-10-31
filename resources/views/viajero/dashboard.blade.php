@extends('layouts.app-dashboard')

@section('title', 'Dashboard Viajero')
@section('role-name', 'Panel de Viajero')
@section('page-title', 'Dashboard Viajero')

@section('sidebar-menu')
    <a href="{{ route('viajero.dashboard') }}" class="active">📊 Dashboard</a>
    <a href="{{ route('viajero.buscar') }}">🔍 Buscar Hospedajes</a>
    <a href="{{ route('viajero.reservas.index') }}">📅 Mis Reservas</a>
    <a href="{{ route('viajero.favoritos') }}">❤️ Favoritos</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Bienvenido, {{ Auth::user()->nombre }}</h2>
    
    <!-- Próximas reservas -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 8px; margin-bottom: 30px;">
        <h3 style="margin-bottom: 10px;">🎉 ¡Encuentra tu próxima aventura!</h3>
        <p style="margin-bottom: 20px; opacity: 0.9;">Explora hospedajes únicos en todo el Perú</p>
        <a href="{{ route('viajero.buscar') }}" class="btn btn-primary" style="background: white; color: #667eea;">
            Buscar Hospedajes
        </a>
    </div>

    <!-- Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Próximas Reservas</h3>
            <p>0</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>Viajes Completados</h3>
            <p>0</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h3>Favoritos</h3>
            <p>0</p>
        </div>
    </div>

    <h3 style="margin-top: 30px; margin-bottom: 15px;">Tus Próximas Reservas</h3>
    <p style="color: #666;">No tienes reservas próximas.</p>
@endsection