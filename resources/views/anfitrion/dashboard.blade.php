@extends('layouts.app-dashboard')

@section('title', 'Dashboard Anfitrión')
@section('role-name', 'Panel de Anfitrión')
@section('page-title', 'Dashboard Anfitrión')

@section('sidebar-menu')
    <a href="{{ route('anfitrion.dashboard') }}" class="active">📊 Dashboard</a>
    <a href="{{ route('anfitrion.hospedajes.index') }}">🏠 Mis Hospedajes</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Bienvenido, {{ Auth::user()->nombre }}</h2>
    
    <!-- Estadísticas del anfitrión -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Mis Hospedajes</h3>
            <p>{{ \App\Models\Hospedaje::where('id_anfitrion', Auth::id())->count() }}</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>Reservas Activas</h3>
            <p>0</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h3>Ganancias del Mes</h3>
            <p>S/. 0</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>Calificación Promedio</h3>
            <p>0.0 ⭐</p>
        </div>
    </div>

    <h3 style="margin-top: 30px; margin-bottom: 15px;">Reservas Recientes</h3>
    <p style="color: #666;">No hay reservas recientes en tus propiedades.</p>
    
    <div style="margin-top: 30px;">
        <h3 style="margin-bottom: 15px;">Acciones Rápidas</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('anfitrion.hospedajes.create') }}" class="btn btn-primary">+ Publicar Nuevo Hospedaje</a>
            <a href="{{ route('anfitrion.hospedajes.index') }}" class="btn btn-primary">Ver Mis Hospedajes</a>
        </div>
    </div>
@endsection