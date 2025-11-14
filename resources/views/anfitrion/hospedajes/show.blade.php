<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hospedaje->titulo }} - Aloja</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        
        .header { background: #1e3a8a; color: white; padding: 20px 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 28px; font-weight: bold; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; }
        
        .back-btn { display: inline-block; margin: 20px 0; color: #1e3a8a; text-decoration: none; font-weight: 600; }
        .back-btn:hover { text-decoration: underline; }
        
        .hero-section { background: white; border-radius: 12px; padding: 40px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .hero-image { width: 100%; height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 120px; margin-bottom: 30px; }
        
        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
        .main-content { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .sidebar { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        
        h1 { font-size: 32px; margin-bottom: 15px; color: #333; }
        .location { color: #666; font-size: 18px; margin-bottom: 20px; }
        
        .status-badge { display: inline-block; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600; margin-bottom: 20px; }
        .status-activo { background: #d1fae5; color: #065f46; }
        .status-inactivo { background: #fee2e2; color: #991b1b; }
        
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin: 30px 0; }
        .info-item { padding: 20px; background: #f9fafb; border-radius: 8px; }
        .info-label { font-size: 14px; color: #666; margin-bottom: 5px; }
        .info-value { font-size: 24px; font-weight: bold; color: #1e3a8a; }
        
        .amenities-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin: 20px 0; }
        .amenity { display: flex; align-items: center; gap: 10px; padding: 15px; background: #f9fafb; border-radius: 8px; }
        
        .stats-box { background: #f9fafb; padding: 25px; border-radius: 8px; margin-bottom: 20px; }
        .stat-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e5e7eb; }
        .stat-row:last-child { border-bottom: none; }
        
        .btn { padding: 12px 24px; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-block; border: none; cursor: pointer; }
        .btn-primary { background: #1e3a8a; color: white; }
        .btn-warning { background: #f59e0b; color: white; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-success { background: #10b981; color: white; }
        
        .actions { display: flex; gap: 10px; margin-top: 20px; }
        
        .reservas-section { margin-top: 40px; padding-top: 40px; border-top: 2px solid #e5e7eb; }
        .reserva-card { background: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 15px; }
        .reserva-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        
        .badge-confirmada { background: #d1fae5; color: #065f46; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-pendiente { background: #fef3c7; color: #92400e; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-cancelada { background: #fee2e2; color: #991b1b; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">🏠 Aloja</div>
                <div class="nav-links">
                    <a href="{{ route('home') }}">Inicio</a>
                    <a href="{{ route('anfitrion.dashboard') }}">Dashboard</a>
                    <a href="{{ route('anfitrion.hospedajes.index') }}">Mis Hospedajes</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <a href="{{ route('anfitrion.hospedajes.index') }}" class="back-btn">← Volver a Mis Hospedajes</a>

        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-image">🏠</div>
            
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h1>{{ $hospedaje->titulo }}</h1>
                    <div class="location">📍 {{ $hospedaje->ubicacion }}</div>
                    <span class="status-badge {{ $hospedaje->disponible ? 'status-activo' : 'status-inactivo' }}">
                        {{ $hospedaje->disponible ? '✅ Activo' : '⏸️ Inactivo' }}
                    </span>
                </div>
                <div class="actions">
                    <a href="{{ route('anfitrion.hospedajes.edit', $hospedaje->id_hospedaje) }}" class="btn btn-warning">
                        ✏️ Editar
                    </a>
                    <form action="{{ route('anfitrion.hospedajes.destroy', $hospedaje->id_hospedaje) }}" method="POST" style="display: inline;" 
                          onsubmit="return confirm('¿Seguro que deseas eliminar este hospedaje?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            🗑️ Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Main Content -->
            <div class="main-content">
                <h2 style="margin-bottom: 20px;">Información del Hospedaje</h2>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Precio por Noche</div>
                        <div class="info-value">S/. {{ number_format($hospedaje->precio, 2) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Capacidad</div>
                        <div class="info-value">{{ $hospedaje->capacidad }} personas</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Total Reservas</div>
                        <div class="info-value">{{ $hospedaje->reservas_count }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Publicado el</div>
                        <div class="info-value" style="font-size: 18px;">{{ $hospedaje->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>

                <h3 style="margin: 30px 0 15px 0;">Descripción</h3>
                <p style="line-height: 1.8; color: #666;">
                    {{ $hospedaje->descripcion ?? 'Sin descripción' }}
                </p>

                <h3 style="margin: 30px 0 15px 0;">Amenidades</h3>
                <div class="amenities-grid">
                    <div class="amenity">
                        @if($hospedaje->wifi)
                            <span style="color: #10b981;">✅</span> WiFi
                        @else
                            <span style="color: #ef4444;">❌</span> WiFi
                        @endif
                    </div>
                    <div class="amenity">
                        @if($hospedaje->cocina)
                            <span style="color: #10b981;">✅</span> Cocina
                        @else
                            <span style="color: #ef4444;">❌</span> Cocina
                        @endif
                    </div>
                    <div class="amenity">
                        @if($hospedaje->estacionamiento)
                            <span style="color: #10b981;">✅</span> Estacionamiento
                        @else
                            <span style="color: #ef4444;">❌</span> Estacionamiento
                        @endif
                    </div>
                </div>

                <!-- Reservas Recientes -->
                @if($reservasRecientes->count() > 0)
                    <div class="reservas-section">
                        <h3 style="margin-bottom: 20px;">📅 Reservas Recientes</h3>
                        
                        @foreach($reservasRecientes as $reserva)
                            <div class="reserva-card">
                                <div class="reserva-header">
                                    <div>
                                        <strong>{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }}</strong>
                                        <div style="color: #666; font-size: 14px;">
                                            {{ $reserva->fecha_inicio->format('d/m/Y') }} - {{ $reserva->fecha_fin->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    <div>
                                        @if($reserva->estado == 'confirmada')
                                            <span class="badge-confirmada">Confirmada</span>
                                        @elseif($reserva->estado == 'pendiente')
                                            <span class="badge-pendiente">Pendiente</span>
                                        @else
                                            <span class="badge-cancelada">{{ ucfirst($reserva->estado) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div style="color: #666; font-size: 14px;">
                                    👥 {{ $reserva->num_huespedes }} huésped(es) • 
                                    💰 S/. {{ number_format($reserva->total, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <h3 style="margin-bottom: 20px;">📊 Estadísticas</h3>
    
                <div class="stats-box">
                    <div class="stat-row">
                        <span>Total Reservas</span>
                        <strong>{{ $hospedaje->reservas_count }}</strong>
                    </div>
                    <div class="stat-row">
                        <span>Estado</span>
                        @if($hospedaje->disponible)
                            <strong style="color: #10b981;">Activo</strong>
                        @else
                            <strong style="color: #ef4444;">Inactivo</strong>
                        @endif
                    </div>
                    <div class="stat-row">
                        <span>Precio/Noche</span>
                        <strong>S/. {{ number_format($hospedaje->precio, 2) }}</strong>
                    </div>
                    <div class="stat-row">
                        <span>Capacidad</span>
                        <strong>{{ $hospedaje->capacidad }} personas</strong>
                    </div>
                </div> 

    <div style="height: 50px;"></div>
</body>
</html>