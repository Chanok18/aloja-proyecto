<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aloja- Tu estadia a un click de distancia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        
        .header { background: #1e3a8a; color: white; padding: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 28px; font-weight: bold; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { color: white; text-decoration: none; }
        .btn { padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #f59e0b; color: white; }
        
        .search-section { background: white; padding: 30px; margin: 30px auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .filters { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .filter-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .filter-group input, .filter-group select { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px; }
        
        .hospedajes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; margin-top: 30px; }
        .hospedaje-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .hospedaje-card:hover { transform: translateY(-5px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .card-image { width: 100%; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; }
        .card-content { padding: 20px; }
        .card-title { font-size: 18px; font-weight: bold; margin-bottom: 10px; color: #333; }
        .card-location { color: #666; margin-bottom: 10px; }
        .card-amenities { display: flex; gap: 10px; margin-bottom: 15px; font-size: 14px; }
        .card-footer { display: flex; justify-content: space-between; align-items: center; }
        .price { font-size: 24px; font-weight: bold; color: #1e3a8a; }
        .price small { font-size: 14px; color: #666; }
        
        .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 30px; }
        .pagination a, .pagination span { padding: 10px 15px; background: white; border-radius: 5px; text-decoration: none; color: #333; }
        .pagination span { background: #1e3a8a; color: white; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">🏠 Aloja</div>
                <div class="nav-links">
                    <a href="{{ route('home') }}">Buscar</a>
                    @auth
                        <a href="{{ route('dashboard') }}">Mi Panel</a>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">Cerrar Sesión</button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-secondary" style="margin-right: 10px;">Regístrate</a>
                        <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Buscador y Filtros -->
        <div class="search-section">
            <h1 style="margin-bottom: 20px;">Encuentra tu hospedaje perfecto</h1>
            
            <form action="{{ route('hospedajes.publico.index') }}" method="GET">
                <div class="filters">
                    <div class="filter-group">
                        <label>Ubicación</label>
                        <input type="text" name="ubicacion" value="{{ request('ubicacion') }}" placeholder="Lima, Cusco, Arequipa...">
                    </div>
                    
                    <div class="filter-group">
                        <label>Precio máximo (S/.)</label>
                        <input type="number" name="precio_max" value="{{ request('precio_max') }}" placeholder="300">
                    </div>
                    
                    <div class="filter-group">
                        <label>Capacidad (personas)</label>
                        <input type="number" name="capacidad" value="{{ request('capacidad') }}" min="1" placeholder="2">
                    </div>
                    
                    <div class="filter-group">
                        <label>Amenidades</label>
                        <div style="display: flex; gap: 15px; margin-top: 10px;">
                            <label style="display: flex; align-items: center; gap: 5px; font-weight: normal;">
                                <input type="checkbox" name="wifi" value="1" {{ request('wifi') ? 'checked' : '' }}>
                                WiFi
                            </label>
                            <label style="display: flex; align-items: center; gap: 5px; font-weight: normal;">
                                <input type="checkbox" name="cocina" value="1" {{ request('cocina') ? 'checked' : '' }}>
                                Cocina
                            </label>
                            <label style="display: flex; align-items: center; gap: 5px; font-weight: normal;">
                                <input type="checkbox" name="estacionamiento" value="1" {{ request('estacionamiento') ? 'checked' : '' }}>
                                Estacionamiento
                            </label>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary" style="border: none; cursor: pointer;">🔍 Buscar</button>
            </form>
        </div>

        <!-- Resultados -->
        <div style="margin-bottom: 20px;">
            <h2>{{ $hospedajes->total() }} hospedajes encontrados</h2>
        </div>

        <div class="hospedajes-grid">
            @forelse($hospedajes as $hospedaje)
                <div class="hospedaje-card">
                    <div class="card-image">🏠</div>
                    <div class="card-content">
                        <div class="card-title">{{ $hospedaje->titulo }}</div>
                        <div class="card-location">📍 {{ $hospedaje->ubicacion }}</div>
                        
                        <div class="card-amenities">
                            @if($hospedaje->wifi) <span>📶 WiFi</span> @endif
                            @if($hospedaje->cocina) <span>🍳 Cocina</span> @endif
                            @if($hospedaje->estacionamiento) <span>🚗 Parking</span> @endif
                        </div>
                        
                        <div style="margin-bottom: 15px; color: #666;">
                            👥 Capacidad: {{ $hospedaje->capacidad }} personas
                        </div>
                        
                        <div class="card-footer">
                            <div class="price">
                                S/. {{ number_format($hospedaje->precio, 0) }}
                                <small>/noche</small>
                            </div>
                            <a href="{{ route('hospedajes.publico.show', $hospedaje->id_hospedaje) }}" class="btn btn-primary">Ver detalles</a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: #999;">
                    <p style="font-size: 48px; margin-bottom: 20px;">🏠</p>
                    <p style="font-size: 18px;">No se encontraron hospedajes con esos criterios.</p>
                    <p style="margin-top: 10px;">Intenta modificar los filtros de búsqueda.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if($hospedajes->hasPages())
            <div class="pagination">
                @if ($hospedajes->onFirstPage())
                    <span>Anterior</span>
                @else
                    <a href="{{ $hospedajes->previousPageUrl() }}">Anterior</a>
                @endif

                <span>Página {{ $hospedajes->currentPage() }}</span>

                @if ($hospedajes->hasMorePages())
                    <a href="{{ $hospedajes->nextPageUrl() }}">Siguiente</a>
                @else
                    <span>Siguiente</span>
                @endif
            </div>
        @endif
    </div>

    <div style="height: 50px;"></div>
</body>
</html>



