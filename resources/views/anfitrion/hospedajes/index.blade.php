<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Hospedajes - Aloja</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        
        .header { background: #1e3a8a; color: white; padding: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 20px; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 28px; font-weight: bold; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; }
        
        .page-header { background: white; padding: 30px; border-radius: 8px; margin: 30px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .page-header h1 { color: #1e3a8a; margin-bottom: 10px; }
        .breadcrumb { color: #666; font-size: 14px; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .stat-icon { font-size: 40px; margin-bottom: 10px; }
        .stat-value { font-size: 36px; font-weight: bold; color: #1e3a8a; }
        .stat-label { color: #666; font-size: 14px; }
        
        .action-bar { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        
        .btn { padding: 12px 24px; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-block; border: none; cursor: pointer; }
        .btn-primary { background: #1e3a8a; color: white; }
        .btn-success { background: #10b981; color: white; }
        .btn-warning { background: #f59e0b; color: white; }
        .btn-danger { background: #ef4444; color: white; }
        
        .hospedajes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; }
        .hospedaje-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .hospedaje-card:hover { transform: translateY(-5px); }
        
        .hospedaje-image { width: 100%; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; font-size: 80px; }
        
        .hospedaje-content { padding: 20px; }
        .hospedaje-title { font-size: 20px; font-weight: bold; color: #333; margin-bottom: 10px; }
        .hospedaje-location { color: #666; margin-bottom: 15px; }
        
        .hospedaje-details { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin: 15px 0; padding: 15px 0; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; }
        .detail-item { font-size: 14px; color: #666; }
        
        .hospedaje-status { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-activo { background: #d1fae5; color: #065f46; }
        .status-inactivo { background: #fee2e2; color: #991b1b; }
        
        .hospedaje-actions { display: flex; gap: 10px; margin-top: 15px; }
        .btn-small { padding: 8px 16px; font-size: 14px; }
        
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        
        .empty-state { text-align: center; padding: 80px 20px; background: white; border-radius: 8px; }
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
            <h1>🏠 Mis Hospedajes</h1>
            <div class="breadcrumb">Dashboard / Mis Hospedajes</div>
        </div>

        <!-- Mensajes -->
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🏠</div>
                <div class="stat-value">{{ $total }}</div>
                <div class="stat-label">Total Hospedajes</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-value">{{ $activos }}</div>
                <div class="stat-label">Activos</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⏸️</div>
                <div class="stat-value">{{ $inactivos }}</div>
                <div class="stat-label">Inactivos</div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
            <h2 style="color: #333;">📋 Lista de Hospedajes</h2>
            <a href="{{ route('anfitrion.hospedajes.create') }}" class="btn btn-success">
                + Publicar Nuevo Hospedaje
            </a>
        </div>

        <!-- Grid de Hospedajes -->
        @if($hospedajes->count() > 0)
            <div class="hospedajes-grid">
                @foreach($hospedajes as $hospedaje)
                    <div class="hospedaje-card">
                        <div class="hospedaje-image">🏠</div>
                        <div class="hospedaje-content">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                                <h3 class="hospedaje-title">{{ $hospedaje->titulo }}</h3>
                                <span class="hospedaje-status {{ $hospedaje->disponible ? 'status-activo' : 'status-inactivo' }}">
                                    {{ $hospedaje->disponible ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                            
                            <div class="hospedaje-location">📍 {{ $hospedaje->ubicacion }}</div>
                            
                            <div class="hospedaje-details">
                                <div class="detail-item">💰 S/. {{ number_format($hospedaje->precio, 2) }}/noche</div>
                                <div class="detail-item">👥 {{ $hospedaje->capacidad }} personas</div>
                                <div class="detail-item">📅 {{ $hospedaje->reservas_count }} reservas</div>
                                <div class="detail-item">📆 {{ $hospedaje->created_at->format('d/m/Y') }}</div>
                            </div>

                            <div class="hospedaje-actions">
                                <a href="{{ route('anfitrion.hospedajes.show', $hospedaje->id_hospedaje) }}" class="btn btn-primary btn-small">
                                    👁️ Ver
                                </a>
                                <a href="{{ route('anfitrion.hospedajes.edit', $hospedaje->id_hospedaje) }}" class="btn btn-warning btn-small">
                                    ✏️ Editar
                                </a>
                                <form action="{{ route('anfitrion.hospedajes.destroy', $hospedaje->id_hospedaje) }}" method="POST" style="display: inline;" 
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este hospedaje?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-small">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div style="margin-top: 30px;">
                {{ $hospedajes->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">🏠</div>
                <h2 style="color: #666; margin-bottom: 10px;">No tienes hospedajes publicados</h2>
                <p style="color: #999; margin-bottom: 30px;">Comienza publicando tu primer hospedaje</p>
                <a href="{{ route('anfitrion.hospedajes.create') }}" class="btn btn-success">
                    + Publicar Mi Primer Hospedaje
                </a>
            </div>
        @endif
    </div>

    <div style="height: 50px;"></div>
</body>
</html>