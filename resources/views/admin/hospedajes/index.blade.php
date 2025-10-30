@extends('layouts.app-dashboard')

@section('title', 'Hospedajes')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Gestión de Hospedajes')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}" class="active">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
    <a href="{{ route('admin.usuarios.index') }}">👥 Usuarios</a>
@endsection

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Lista de Hospedajes</h2>
        <button class="btn btn-primary">+ Nuevo Hospedaje</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Ubicación</th>
                <th>Anfitrión</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                    No hay hospedajes registrados aún.
                </td>
            </tr>
        </tbody>
    </table>
@endsection