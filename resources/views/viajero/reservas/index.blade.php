@extends('layouts.app-dashboard')

@section('title', 'Mis Reservas')
@section('role-name', 'Panel de Viajero')
@section('page-title', 'Mis Reservas')

@section('sidebar-menu')
    <a href="{{ route('viajero.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('viajero.buscar') }}">🔍 Buscar Hospedajes</a>
    <a href="{{ route('viajero.reservas.index') }}" class="active">📅 Mis Reservas</a>
    <a href="{{ route('viajero.favoritos') }}">❤️ Favoritos</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Mis Reservas</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Hospedaje</th>
                <th>Ubicación</th>
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
                    No tienes reservas aún. <br>
                    <a href="{{ route('viajero.buscar') }}" class="btn btn-primary" style="margin-top: 15px;">Buscar Hospedajes</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection