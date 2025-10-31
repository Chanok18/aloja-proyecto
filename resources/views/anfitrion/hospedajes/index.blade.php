@extends('layouts.app-dashboard')

@section('title', 'Mis Hospedajes')
@section('role-name', 'Panel de Anfitrión')
@section('page-title', 'Mis Hospedajes')

@section('sidebar-menu')
    <a href="{{ route('anfitrion.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('anfitrion.hospedajes.index') }}" class="active">🏠 Mis Hospedajes</a>
    <a href="{{ route('anfitrion.reservas.index') }}">📅 Mis Reservas</a>
@endsection

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Mis Hospedajes Publicados</h2>
        <button class="btn btn-primary">+ Publicar Nuevo Hospedaje</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Ubicación</th>
                <th>Precio/Noche</th>
                <th>Capacidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                    No has publicado hospedajes aún. <br>
                    <button class="btn btn-primary" style="margin-top: 15px;">+ Publicar tu primer hospedaje</button>
                </td>
            </tr>
        </tbody>
    </table>
@endsection