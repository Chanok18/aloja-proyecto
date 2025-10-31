@extends('layouts.app-dashboard')

@section('title', 'Favoritos')
@section('role-name', 'Panel de Viajero')
@section('page-title', 'Mis Favoritos')

@section('sidebar-menu')
    <a href="{{ route('viajero.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('viajero.buscar') }}">🔍 Buscar Hospedajes</a>
    <a href="{{ route('viajero.reservas.index') }}">📅 Mis Reservas</a>
    <a href="{{ route('viajero.favoritos') }}" class="active">❤️ Favoritos</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Mis Hospedajes Favoritos</h2>

    <p style="color: #666; text-align: center; padding: 60px;">
        ❤️ No has guardado favoritos aún. <br><br>
        Explora hospedajes y guarda los que más te gusten para verlos después.
        <br><br>
        <a href="{{ route('viajero.buscar') }}" class="btn btn-primary">Explorar Hospedajes</a>
    </p>
@endsection