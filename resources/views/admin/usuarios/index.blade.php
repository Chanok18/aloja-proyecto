@extends('layouts.app-dashboard')

@section('title', 'Usuarios')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Gestión de Usuarios')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
    <a href="{{ route('admin.usuarios.index') }}" class="active">👥 Usuarios</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Lista de Usuarios</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                    Cargando usuarios...
                </td>
            </tr>
        </tbody>
    </table>
@endsection