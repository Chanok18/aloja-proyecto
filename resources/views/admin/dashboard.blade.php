@extends('layouts.app-dashboard')

@section('title', 'Dashboard Admin')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Dashboard Administrador')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="active">📊 Panel de Control</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
@endsection

@section('content')
    <h2 style="margin-bottom: 20px;">Bienvenido, {{ Auth::user()->nombre }}</h2>
    
    @php
        // Estadísticas de Hospedajes
        $totalHospedajes = \App\Models\Hospedaje::count();
        $hospedajesDisponibles = \App\Models\Hospedaje::where('disponible', true)->count();
        $hospedajesNoDisponibles = $totalHospedajes - $hospedajesDisponibles;
        
        // Estadísticas de Reservas
        $totalReservas = \App\Models\Reserva::count();
        $reservasPendientes = \App\Models\Reserva::where('estado', 'pendiente')->count();
        $reservasConfirmadas = \App\Models\Reserva::where('estado', 'confirmada')->count();
        $reservasCanceladas = \App\Models\Reserva::where('estado', 'cancelada')->count();
        
        // Estadísticas de Pagos
        $totalRecaudado = \App\Models\Pago::where('estado_pago', 'completado')->sum('monto');
        $pagosHoy = \App\Models\Pago::where('estado_pago', 'completado')
            ->whereDate('fecha_pago', today())
            ->sum('monto');
        $pagosMes = \App\Models\Pago::where('estado_pago', 'completado')
            ->whereMonth('fecha_pago', now()->month)
            ->whereYear('fecha_pago', now()->year)
            ->sum('monto');
        
        // Estadísticas de Usuarios
        $totalUsuarios = \App\Models\Usuario::count();
        $totalViajeros = \App\Models\Usuario::where('rol', 'viajero')->count();
        $totalAnfitriones = \App\Models\Usuario::where('rol', 'anfitrion')->count();
        $totalAdmins = \App\Models\Usuario::where('rol', 'admin')->count();
        
        // Últimas 5 reservas
        $ultimasReservas = \App\Models\Reserva::with(['usuario', 'hospedaje'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    @endphp
    
    <!-- Estadísticas Principales -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Hospedajes</h3>
            <p>{{ $totalHospedajes }}</p>
            <small style="font-size: 12px; opacity: 0.8;">
                ✅ {{ $hospedajesDisponibles }} Disponibles | ❌ {{ $hospedajesNoDisponibles }} No disponibles
            </small>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>Reservas Totales</h3>
            <p>{{ $totalReservas }}</p>
            <small style="font-size: 12px; opacity: 0.8;">
                ⏳ {{ $reservasPendientes }} Pendientes | ✅ {{ $reservasConfirmadas }} Confirmadas
            </small>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h3>Recaudación Total</h3>
            <p>S/. {{ number_format($totalRecaudado, 2) }}</p>
            <small style="font-size: 12px; opacity: 0.8;">
                Hoy: S/. {{ number_format($pagosHoy, 2) }} | Mes: S/. {{ number_format($pagosMes, 2) }}
            </small>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>Usuarios Totales</h3>
            <p>{{ $totalUsuarios }}</p>
            <small style="font-size: 12px; opacity: 0.8;">
                👤 {{ $totalViajeros }} Viajeros | 🏠 {{ $totalAnfitriones }} Anfitriones | 👨‍💼 {{ $totalAdmins }} Admins
            </small>
        </div>
    </div>

    <!-- Últimas Reservas -->
    <h3 style="margin-top: 30px; margin-bottom: 15px;">Últimas Reservas</h3>
    
    @if($ultimasReservas->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Hospedaje</th>
                    <th>Fechas</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha Reserva</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ultimasReservas as $reserva)
                    <tr>
                        <td>{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }}</td>
                        <td>{{ $reserva->hospedaje->titulo }}</td>
                        <td>{{ $reserva->fecha_inicio->format('d/m/Y') }} - {{ $reserva->fecha_fin->format('d/m/Y') }}</td>
                        <td>S/. {{ number_format($reserva->total, 2) }}</td>
                        <td>
                            @if($reserva->estado == 'confirmada')
                                <span class="badge badge-success">✅ Confirmada</span>
                            @elseif($reserva->estado == 'pendiente')
                                <span class="badge badge-warning">⏳ Pendiente</span>
                            @elseif($reserva->estado == 'cancelada')
                                <span class="badge badge-danger">❌ Cancelada</span>
                            @else
                                <span class="badge badge-success">✅ Completada</span>
                            @endif
                        </td>
                        <td>{{ $reserva->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color: #666;">No hay reservas registradas aún.</p>
    @endif
    
    <!-- Accesos Rápidos -->
    <div style="margin-top: 30px;">
        <h3 style="margin-bottom: 15px;">Accesos Rápidos</h3>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.hospedajes.index') }}" class="btn btn-primary">🏠 Ver Hospedajes</a>
            <a href="{{ route('admin.reservas.index') }}" class="btn btn-primary">📅 Ver Reservas</a>
            <a href="{{ route('admin.pagos.index') }}" class="btn btn-primary">💳 Ver Pagos</a>
            <a href="{{ route('admin.resenas.index') }}" class="btn btn-primary">⭐ Ver Reseñas</a>
        </div>
    </div>
@endsection