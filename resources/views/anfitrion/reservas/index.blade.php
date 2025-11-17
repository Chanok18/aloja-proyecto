<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - Aloja</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        
        .header { background: #1e3a8a; color: white; padding: 20px 0; }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 20px; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 28px; font-weight: bold; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; }
        
        .page-header { background: white; padding: 30px; border-radius: 8px; margin: 30px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .page-header h1 { color: #1e3a8a; margin-bottom: 10px; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center; }
        .stat-icon { font-size: 40px; margin-bottom: 10px; }
        .stat-value { font-size: 36px; font-weight: bold; color: #1e3a8a; }
        .stat-label { color: #666; font-size: 14px; margin-top: 5px; }
        
        .filter-bar { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        
        .reservas-table { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f9fafb; padding: 15px; text-align: left; font-weight: 600; color: #333; border-bottom: 2px solid #e5e7eb; }
        td { padding: 15px; border-bottom: 1px solid #e5e7eb; }
        tr:hover { background: #f9fafb; }
        
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
        .badge-pendiente { background: #fef3c7; color: #92400e; }
        .badge-confirmada { background: #d1fae5; color: #065f46; }
        .badge-cancelada { background: #fee2e2; color: #991b1b; }
        .badge-completada { background: #dbeafe; color: #1e40af; }
        
        .btn { padding: 8px 16px; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-block; font-size: 14px; }
        .btn-primary { background: #1e3a8a; color: white; border: none; }
        .btn-primary:hover { background: #1e40af; }
        
        .empty-state { text-align: center; padding: 80px 20px; }
        .empty-icon { font-size: 100px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">🏠 Aloja</div>
                <div class="nav-links">
                    <a href="{{ route('home') }}">Inicio</a>
                    <a href="{{ route('anfitrion.dashboard') }}">Dashboard</a>
                    <a href="{{ route('anfitrion.hospedajes.index') }}">Mis Hospedajes</a>
                    <a href="{{ route('anfitrion.reservas.index') }}">Reservas</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>📅 Reservas de Mis Hospedajes</h1>
            <p style="color: #666;">Gestiona todas las reservas de tus propiedades</p>
        </div>

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📋</div>
                <div class="stat-value">{{ $total }}</div>
                <div class="stat-label">Total Reservas</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <div class="stat-value">{{ $pendientes }}</div>
                <div class="stat-label">Pendientes</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-value">{{ $confirmadas }}</div>
                <div class="stat-label">Confirmadas</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-value">S/. {{ number_format($ingresos, 0) }}</div>
                <div class="stat-label">Ingresos Confirmados</div>
            </div>
        </div>

        <!-- Tabla de Reservas -->
        @if($reservas->count() > 0)
            <div class="reservas-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hospedaje</th>
                            <th>Viajero</th>
                            <th>Fechas</th>
                            <th>Huéspedes</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservas as $reserva)
                            <tr>
                                <td><strong>#{{ $reserva->id_reserva }}</strong></td>
                                <td>
                                    <strong>{{ $reserva->hospedaje->titulo }}</strong><br>
                                    <small style="color: #666;">{{ $reserva->hospedaje->ubicacion }}</small>
                                </td>
                                <td>
                                    {{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }}<br>
                                    <small style="color: #666;">{{ $reserva->usuario->correo }}</small>
                                </td>
                                <td>
                                    <strong>Check-in:</strong> {{ $reserva->fecha_inicio->format('d/m/Y') }}<br>
                                    <strong>Check-out:</strong> {{ $reserva->fecha_fin->format('d/m/Y') }}<br>
                                    <small style="color: #666;">{{ $reserva->diasReservados() }} noches</small>
                                </td>
                                <td>
                                    <strong>{{ $reserva->num_huespedes }}</strong> 
                                    {{ $reserva->num_huespedes == 1 ? 'persona' : 'personas' }}
                                </td>
                                <td><strong style="color: #1e3a8a;">S/. {{ number_format($reserva->total, 2) }}</strong></td>
                                <td>
                                    <span class="badge badge-{{ $reserva->estado }}">
                                        @if($reserva->estado == 'pendiente')
                                            ⏳ Pendiente
                                        @elseif($reserva->estado == 'confirmada')
                                            ✅ Confirmada
                                        @elseif($reserva->estado == 'cancelada')
                                            ❌ Cancelada
                                        @else
                                            ✔️ Completada
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('anfitrion.reservas.show', $reserva->id_reserva) }}" class="btn btn-primary">
                                        👁️ Ver Detalle
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $reservas->links() }}
            </div>
        @else
            <div class="empty-state" style="background: white; border-radius: 8px;">
                <div class="empty-icon">📭</div>
                <h2 style="color: #666; margin-bottom: 10px;">No tienes reservas aún</h2>
                <p style="color: #999; margin-bottom: 30px;">Cuando alguien reserve tus hospedajes aparecerán aquí</p>
                <a href="{{ route('anfitrion.hospedajes.index') }}" class="btn btn-primary">
                    Ver Mis Hospedajes
                </a>
            </div>
        @endif
    </div>

    <div style="height: 50px;"></div>
</body>
</html>