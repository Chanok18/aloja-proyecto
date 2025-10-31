@extends('layouts.app-dashboard')

@section('title', 'Buscar Hospedajes')
@section('role-name', 'Panel de Viajero')
@section('page-title', 'Buscar Hospedajes')

@section('sidebar-menu')
    <a href="{{ route('viajero.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('viajero.buscar') }}" class="active">🔍 Buscar Hospedajes</a>
    <a href="{{ route('viajero.reservas.index') }}">📅 Mis Reservas</a>
    <a href="{{ route('viajero.favoritos') }}">❤️ Favoritos</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Buscar Hospedajes</h2>
    
    <!-- Filtros de búsqueda -->
    <div style="background: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ubicación</label>
                <input type="text" placeholder="¿A dónde vas?" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Check-in</label>
                <input type="date" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Check-out</label>
                <input type="date" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Huéspedes</label>
                <select style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
                    <option>1 huésped</option>
                    <option>2 huéspedes</option>
                    <option>3 huéspedes</option>
                    <option>4+ huéspedes</option>
                </select>
            </div>
        </div>
        <button class="btn btn-primary" style="margin-top: 15px;">🔍 Buscar</button>
    </div>

    <h3 style="margin-bottom: 20px;">Hospedajes Disponibles</h3>
    <p style="color: #666; text-align: center; padding: 60px;">
        No hay hospedajes disponibles aún. <br>
        ¡Pronto habrá opciones increíbles para ti! 🏠
    </p>
@endsection