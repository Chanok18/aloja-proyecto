@extends('layouts.app-dashboard')

@section('title', 'Reservas')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Gestión de Reservas')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}" class="active">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
    <a href="{{ route('admin.usuarios.index') }}">👥 Usuarios</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Lista de Reservas</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Hospedaje</th>
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
                    No hay reservas registradas aún.
                </td>
            </tr>
        </tbody>
    </table>
@endsection