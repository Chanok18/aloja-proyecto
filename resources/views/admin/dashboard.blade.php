@extends('layouts.app-dashboard')

@section('title', 'Dashboard Admin')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Dashboard Administrador')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="active">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Bienvenido, {{ Auth::user()->nombre }}</h2>
    
    <!-- Estadísticas rápidas -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Hospedajes</h3>
            <p>0</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>Reservas Activas</h3>
            <p>0</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h3>Pagos Hoy</h3>
            <p>S/. 0</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>Usuarios Totales</h3>
            <p>0</p>
        </div>
    </div>

    <h3 style="margin-top: 30px; margin-bottom: 15px;">Actividad Reciente</h3>
    <p style="color: #666;">No hay actividad reciente aún.</p>
    
    <div style="margin-top: 30px;">
        <h3 style="margin-bottom: 15px;">Accesos Rápidos</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.hospedajes.index') }}" class="btn btn-primary">Ver Hospedajes</a>
            <a href="{{ route('admin.reservas.index') }}" class="btn btn-primary">Ver Reservas</a>
        </div>
    </div>
@endsection