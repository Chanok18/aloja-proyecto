@extends('layouts.app-dashboard')

@section('title', 'Mis Reservas')
@section('role-name', 'Panel de Anfitrión')
@section('page-title', 'Reservas de Mis Hospedajes')

@section('sidebar-menu')
    <a href="{{ route('anfitrion.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('anfitrion.hospedajes.index') }}">🏠 Mis Hospedajes</a>
    <a href="{{ route('anfitrion.reservas.index') }}" class="active">📅 Mis Reservas</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Reservas de Tus Hospedajes</h2>

    <div class="stats-grid" style="margin-bottom: 30px;">
        <div class="stat-card">
            <h3>Reservas Pendientes</h3>
            <p>0</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>Reservas Confirmadas</h3>
            <p>0</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h3>Total Este Mes</h3>
            <p>0</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Hospedaje</th>
                <th>Huésped</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="8" style="text-align: center; padding: 40px; color: #999;">
                    No hay reservas en tus propiedades aún.
                </td>
            </tr>
        </tbody>
    </table>
@endsection