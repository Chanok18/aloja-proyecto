<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aloja - Encuentra tu hospedaje perfecto en Perú</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-blue: #1e3a8a;
            --primary-orange: #f59e0b;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }
        
        .navbar-custom {
            background: var(--primary-blue);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: white !important;
        }
        
        .navbar-brand small {
            display: block;
            font-size: 0.7rem;
            font-weight: normal;
            color: #e0e7ff;
        }
        
        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 10px;
        }
        
        .btn-register {
            background: var(--primary-orange);
            color: white;
            font-weight: 600;
            border: none;
            padding: 8px 24px;
            border-radius: 25px;
        }
        
        .btn-register:hover {
            background: #d97706;
            color: white;
        }

        .carousel-section {
            margin-top: 20px;
        }
        .carousel-item {
            height: 450px;
        }
        .carousel-image {
            height: 100%;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .carousel-caption-custom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
            padding: 60px 20px 40px 20px;
            text-align: center;
        }
        .carousel-caption-custom h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            margin-bottom: 10px;
        }

        .carousel-caption-custom p {
            font-size: 1.2rem;
            color: white;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: var(--primary-orange);
            border-radius: 50%;
            padding: 20px;
        }
        .search-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            margin-top: -60px;
            position: relative;
            z-index: 10;
        }
        
        .search-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary-blue);
        }
        
        .form-control, .form-select {
            border: 2px solid #e5e7eb;
            padding: 12px;
            border-radius: 8px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.15);
        }
        
        .btn-search {
            background: var(--primary-orange);
            color: white;
            font-weight: 600;
            padding: 12px 40px;
            border: none;
            border-radius: 25px;
            font-size: 1.1rem;
        }
        
        .btn-search:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
        }
        
        .hospedajes-section {
            padding: 60px 0;
        }
        
        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-blue);
            margin-bottom: 10px;
        }
        
        .hospedaje-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 100%;
        }
        .hospedaje-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .hospedaje-image {
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
        }
        .hospedaje-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-blue);
            margin-bottom: 8px;
        }
        
        .hospedaje-location {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        
        .hospedaje-amenities {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        
        .amenity-badge {
            background: #eff6ff;
            color: var(--primary-blue);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        .hospedaje-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-blue);
        }
        
        .hospedaje-price small {
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: normal;
        }
        
        .btn-detail {
            background: var(--primary-orange);
            color: white;
            font-weight: 600;
            border: none;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
        }
        
        .btn-detail:hover {
            background: #d97706;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                Aloja.pe
                <small>Tu estadía, a un clic de distancia</small>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Hospedajes</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Mi Panel</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Cerrar Sesión</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-register" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <section class="carousel-section">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            
            <div class="carousel-inner">
                
                <div class="carousel-item active">
                    <div class="carousel-image" style="background: linear-gradient(rgba(30, 58, 138, 0.5), rgba(30, 58, 138, 0.5)), url('https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=1200') center/cover;">
                        <div class="carousel-caption-custom">
                            <h2>Encuentra tu estadía perfecta</h2>
                            <p>Hospedajes únicos</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-image" style="background: linear-gradient(rgba(30, 58, 138, 0.5), rgba(30, 58, 138, 0.5)), url('https://images.unsplash.com/photo-1531968455001-5c5272a41129?w=1200') center/cover;">
                        <div class="carousel-caption-custom">
                            <h2>Encuentra tu estadía perfecta</h2>
                            <p>Modernidad y tradición en la capital</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <div class="container">
        <div class="search-card">
            <h2 class="search-title">Encuentra tu hospedaje perfecto</h2>
            
            <form action="{{ route('home') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Ubicación</label>
                        <input type="text" name="ubicacion" class="form-control" 
                               placeholder="Lima, Cusco, Arequipa..." 
                               value="{{ request('ubicacion') }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Precio máximo (S/.)</label>
                        <input type="number" name="precio_max" class="form-control" 
                               placeholder="300" 
                               value="{{ request('precio_max') }}">
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Capacidad</label>
                        <input type="number" name="capacidad" class="form-control" 
                               placeholder="2" min="1"
                               value="{{ request('capacidad') }}">
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Amenidades</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="wifi" id="wifi" 
                                       {{ request('wifi') ? 'checked' : '' }}>
                                <label class="form-check-label" for="wifi">WiFi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cocina" id="cocina"
                                       {{ request('cocina') ? 'checked' : '' }}>
                                <label class="form-check-label" for="cocina">Cocina</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="estacionamiento" id="estacionamiento"
                                       {{ request('estacionamiento') ? 'checked' : '' }}>
                                <label class="form-check-label" for="estacionamiento">Parking</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-search">
                        <i class="bi bi-search me-2"></i>Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <section class="hospedajes-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">{{ $hospedajes->total() }} hospedajes encontrados</h2>
                <p class="text-muted">Descubre alojamientos únicos en los mejores destinos del Perú</p>
            </div>

            @if($hospedajes->count() > 0)
                <div class="row g-4">
                    @foreach($hospedajes as $hospedaje)
                        <div class="col-md-6 col-lg-4">
                            <div class="card hospedaje-card">
                                <div class="hospedaje-image">🏠</div>
                                
                                <div class="card-body">
                                    <h5 class="hospedaje-title">{{ $hospedaje->titulo }}</h5>
                                    <p class="hospedaje-location">
                                        <i class="bi bi-geo-alt-fill"></i> {{ $hospedaje->ubicacion }}
                                    </p>
                                    
                                    <div class="hospedaje-amenities">
                                        @if($hospedaje->wifi)
                                            <span class="amenity-badge"><i class="bi bi-wifi"></i> WiFi</span>
                                        @endif
                                        @if($hospedaje->cocina)
                                            <span class="amenity-badge"><i class="bi bi-egg-fried"></i> Cocina</span>
                                        @endif
                                        @if($hospedaje->estacionamiento)
                                            <span class="amenity-badge"><i class="bi bi-car-front"></i> Parking</span>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="hospedaje-price">
                                            S/. {{ number_format($hospedaje->precio, 0) }}
                                            <small>/noche</small>
                                        </div>
                                        <div class="text-muted">
                                            <i class="bi bi-people-fill"></i> {{ $hospedaje->capacidad }}
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('hospedajes.publico.show', $hospedaje->id_hospedaje) }}" 
                                       class="btn btn-detail">
                                        Ver detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 d-flex justify-content-center">
                    {{ $hospedajes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-search" style="font-size: 4rem; color: #d1d5db;"></i>
                    <h3 class="mt-3 text-muted">No se encontraron hospedajes</h3>
                </div>
            @endif
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>