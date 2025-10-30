@extends('layouts.app-dashboard')

@section('title', 'Reseñas')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Gestión de Reseñas')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}" class="active">⭐ Reseñas</a>
    <a href="{{ route('admin.usuarios.index') }}">👥 Usuarios</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Lista de Reseñas</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Hospedaje</th>
                <th>Calificación</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                    No hay reseñas registradas aún.
                </td>
            </tr>
        </tbody>
    </table>
@endsection