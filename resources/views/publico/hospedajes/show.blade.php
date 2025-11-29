
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hospedaje->titulo }} - Aloja.pe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #FFFFFF; color: #222; }
        
        /* Navbar */
        .navbar { background: #2B4F9B; padding: 16px 0; position: sticky; top: 0; z-index: 1000; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .nav-container { max-width: 1280px; margin: 0 auto; padding: 0 24px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 26px; font-weight: 700; color: white; text-decoration: none; }
        .logo .pe { color: #F5C344; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { color: white; text-decoration: none; font-weight: 500; transition: opacity 0.2s; }
        .nav-links a:hover { opacity: 0.8; }
        .btn-nav { padding: 10px 20px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; }
        .btn-primary { background: #F5C344; color: #1A1A1A; }
        .btn-primary:hover { background: #E5B334; transform: translateY(-1px); }
        .btn-secondary { background: rgba(255,255,255,0.1); color: white; border: 2px solid rgba(255,255,255,0.3); }
        .btn-secondary:hover { background: rgba(255,255,255,0.2); }
        
        /* Container */
        .container { max-width: 1120px; margin: 0 auto; padding: 0 24px; }
        .back-link { display: inline-flex; align-items: center; gap: 8px; color: #2B4F9B; text-decoration: none; font-weight: 600; margin: 24px 0; transition: gap 0.2s; }
        .back-link:hover { gap: 12px; }
        
        /* Header */
        .header { margin-bottom: 24px; }
        .header h1 { font-size: 26px; font-weight: 700; margin-bottom: 8px; }
        .header-meta { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; font-size: 14px; }
        .rating { display: flex; align-items: center; gap: 4px; font-weight: 600; }
        .location { color: #717171; }
        
        /* Gallery */
        .gallery { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; border-radius: 12px; overflow: hidden; margin-bottom: 48px; max-height: 400px; }
        .gallery-main { grid-row: 1 / 3; }
        .gallery img { width: 100%; height: 100%; object-fit: cover; cursor: pointer; transition: filter 0.2s; }
        .gallery img:hover { filter: brightness(0.9); }
        .gallery-placeholder { background: linear-gradient(135deg, #2B4F9B, #1e3a8a); display: flex; align-items: center; justify-content: center; color: white; font-size: 80px; }
        
        /* Layout */
        .layout { display: grid; grid-template-columns: 1fr 380px; gap: 80px; margin-bottom: 48px; }
        
        /* Main Content */
        .main { max-width: 100%; }
        .section { padding: 32px 0; border-bottom: 1px solid #EBEBEB; }
        .section:last-child { border: none; }
        .section-title { font-size: 22px; font-weight: 600; margin-bottom: 24px; }
        
        /* Host */
        .host { display: flex; align-items: center; gap: 16px; }
        .host-avatar { width: 56px; height: 56px; border-radius: 50%; background: #10B981; display: flex; align-items: center; justify-content: center; color: white; font-size: 22px; font-weight: 700; }
        .host-info h3 { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
        .host-info p { font-size: 14px; color: #717171; }
        
        /* Details */
        .details { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .detail { display: flex; align-items: center; gap: 12px; font-size: 16px; }
        .detail-icon { font-size: 24px; }
        
        /* Description */
        .description { line-height: 1.6; color: #222; font-size: 16px; }
        
        /* Amenities */
        .amenities { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .amenity { display: flex; align-items: center; gap: 12px; font-size: 16px; }
        .available { color: #10B981; }
        .unavailable { color: #EF4444; opacity: 0.5; }
        
        /* Reviews */
        .reviews-header { display: flex; align-items: center; gap: 8px; font-size: 20px; font-weight: 600; margin-bottom: 32px; }
        .review { background: #F7F7F7; padding: 24px; border-radius: 12px; margin-bottom: 16px; }
        .review-header { display: flex; justify-content: space-between; margin-bottom: 12px; }
        .review-user { font-weight: 600; font-size: 15px; }
        .review-date { font-size: 13px; color: #717171; margin-top: 2px; }
        .review-stars { color: #F5C344; }
        .review-text { line-height: 1.5; color: #222; font-size: 15px; }
        
        /* Booking Card */
        .booking { position: sticky; top: 100px; background: white; border: 1px solid #DDDDDD; border-radius: 12px; padding: 24px; box-shadow: 0 6px 16px rgba(0,0,0,0.12); }
        .price-box { display: flex; align-items: baseline; gap: 4px; padding-bottom: 24px; border-bottom: 1px solid #EBEBEB; margin-bottom: 24px; }
        .price { font-size: 22px; font-weight: 600; }
        .price-period { font-size: 16px; color: #717171; }
        .price-rating { margin-left: auto; font-size: 14px; font-weight: 600; }
        
        /* Form */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; margin-bottom: 8px; }
        .form-input { width: 100%; padding: 11px 12px; border: 1px solid #B0B0B0; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; }
        .form-input:focus { outline: none; border-color: #222; box-shadow: 0 0 0 2px rgba(34,34,34,0.1); }
        .form-hint { font-size: 12px; color: #717171; margin-top: 4px; }
        .form-error { font-size: 12px; color: #C13515; margin-top: 4px; display: block; }
        .btn-reserve { width: 100%; background: linear-gradient(to right, #E61E4D 0%, #E31C5F 50%, #D70466 100%); color: white; padding: 14px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-reserve:hover { transform: scale(1.02); }
        .booking-note { text-align: center; font-size: 14px; color: #717171; margin-top: 16px; }
        .alert { background: #FFF3CD; border: 1px solid #FFC107; color: #856404; padding: 12px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        
        /* Login Prompt */
        .login-box { text-align: center; }
        .login-box p { margin-bottom: 16px; color: #717171; }
        .btn-login { display: block; width: 100%; background: #2B4F9B; color: white; padding: 14px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s; }
        .btn-login:hover { background: #1e3a8a; }
        .register-link { margin-top: 12px; font-size: 14px; color: #717171; }
        .register-link a { color: #2B4F9B; font-weight: 600; text-decoration: none; }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .layout { grid-template-columns: 1fr; gap: 40px; }
            .booking { position: relative; top: 0; }
            .gallery { grid-template-columns: 1fr; max-height: none; }
            .gallery-main { grid-row: auto; }
            .gallery img { height: 300px; }
        }
        
        @media (max-width: 640px) {
            .header h1 { font-size: 22px; }
            .details, .amenities { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">Aloja<span class="pe">.pe</span></a>
            <div class="nav-links">
                <a href="{{ route('home') }}">Inicio</a>
                <a href="{{ route('hospedajes.publico.index') }}">Hospedajes</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-nav btn-primary">Mi Panel</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-nav btn-secondary">Cerrar Sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-nav btn-secondary">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn-nav btn-primary">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <a href="{{ route('home') }}" class="back-link">← Volver a resultados</a>

        <!-- Header -->
        <div class="header">
            <h1>{{ $hospedaje->titulo }}</h1>
            <div class="header-meta">
                @if($hospedaje->resenas->count() > 0)
                    <span class="rating">⭐ {{ number_format($hospedaje->promedioCalificacion(), 1) }} ({{ $hospedaje->totalResenas() }} reseñas)</span>
                @endif
                <span class="location">📍 {{ $hospedaje->ubicacion }}</span>
            </div>
        </div>
        <!-- Gallery -->
        @php $fotos = $hospedaje->fotos_galeria; @endphp
        @if($fotos->count() > 0)
            <div class="gallery">
                <div class="gallery-main">
                    <img src="{{ asset('storage/' . $fotos->first()->ruta_foto) }}" alt="{{ $hospedaje->titulo }}">
                </div>
                @foreach($fotos->slice(1, 3) as $foto)
                    <div><img src="{{ asset('storage/' . $foto->ruta_foto) }}" alt="{{ $hospedaje->titulo }}"></div>
                @endforeach
            </div>
        @else
            <div class="gallery"><div class="gallery-main gallery-placeholder"></div></div>
        @endif

        <!-- Layout -->
        <div class="layout">
            <!-- Main Content -->
            <div class="main">
                <!-- Host -->
                <div class="section">
                    <div class="host">
                        <div class="host-avatar">{{ strtoupper(substr($hospedaje->anfitrion->nombre, 0, 1)) }}</div>
                        <div class="host-info">
                            <h3>Anfitrión: {{ $hospedaje->anfitrion->nombre }} {{ $hospedaje->anfitrion->apellido }}</h3>
                            <p>Miembro desde {{ $hospedaje->anfitrion->created_at->format('Y') }}</p>
                        </div>
                    </div>
                </div>
                <!-- Details -->
                <div class="section">
                    <h2 class="section-title">Detalles del hospedaje</h2>
                    <div class="details">
                        <div class="detail"><span class="detail-icon">👥</span> <strong>Capacidad</strong>: {{ $hospedaje->capacidad }} huéspedes</div>
                        <div class="detail"><span class="detail-icon">💰</span> <strong>Precio</strong>: S/. {{ number_format($hospedaje->precio, 2) }}</div>
                    </div>
                </div>
                <!-- Description -->
                <div class="section">
                    <h2 class="section-title">Descripción</h2>
                    <p class="description">{{ $hospedaje->descripcion ?? 'El anfitrión no ha proporcionado una descripción detallada.' }}</p>
                </div>

                <!-- Amenities -->
                <div class="section">
                    <h2 class="section-title">Lo que ofrece este lugar</h2>
                    <div class="amenities">
                        <div class="amenity {{ $hospedaje->wifi ? 'available' : 'unavailable' }}">{{ $hospedaje->wifi ? '✅' : '❌' }} WiFi de alta velocidad</div>
                        <div class="amenity {{ $hospedaje->cocina ? 'available' : 'unavailable' }}">{{ $hospedaje->cocina ? '✅' : '❌' }} Cocina completa</div>
                        <div class="amenity {{ $hospedaje->estacionamiento ? 'available' : 'unavailable' }}">{{ $hospedaje->estacionamiento ? '✅' : '❌' }} Estacionamiento privado</div>
                        <div class="amenity {{ $hospedaje->aire_acondicionado ? 'available' : 'unavailable' }}">{{ $hospedaje->aire_acondicionado ? '✅' : '❌' }} Aire acondicionado</div>
                        <div class="amenity {{ $hospedaje->tv ? 'available' : 'unavailable' }}">{{ $hospedaje->tv ? '✅' : '❌' }} TV Smart"</div>
                    </div>
                </div>

                <!-- Reviews -->
                @if($hospedaje->resenas->count() > 0)
                    <div class="section">
                        <div class="reviews-header">⭐ {{ number_format($hospedaje->promedioCalificacion(), 1) }} · {{ $hospedaje->totalResenas() }} reseñas</div>
                        @foreach($hospedaje->resenas->take(6) as $resena)
                            <div class="review">
                                <div class="review-header">
                                    <div>
                                        <div class="review-user">{{ $resena->usuario->nombre }} {{ $resena->usuario->apellido }}</div>
                                        <div class="review-date">{{ $resena->fecha_resena->diffForHumans() }}</div>
                                    </div>
                                    <div class="review-stars">@for($i=1;$i<=5;$i++){{ $i<=$resena->calificacion?'⭐':'☆' }}@endfor</div>
                                </div>
                                <p class="review-text">{{ $resena->comentario }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <!-- Booking Card -->
            <div>
                <div class="booking">
                    <div class="price-box">
                        <span class="price">S/. {{ number_format($hospedaje->precio, 0) }}</span>
                        <span class="price-period">/noche</span>
                        @if($hospedaje->resenas->count() > 0)
                            <span class="price-rating">⭐ {{ number_format($hospedaje->promedioCalificacion(), 1) }}</span>
                        @endif
                    </div>
                    @auth
                        @if(session('error'))
                            <div class="alert">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('reservas.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="hospedaje_id" value="{{ $hospedaje->id_hospedaje }}">
                        
                            <div class="form-group">
                                <label class="form-label">Fecha de entrada</label>
                                <input type="date" name="fecha_inicio" class="form-input" required min="{{ date('Y-m-d') }}" value="{{ old('fecha_inicio') }}">
                                @error('fecha_inicio')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Fecha de salida</label>
                                <input type="date" name="fecha_fin" class="form-input" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('fecha_fin') }}">
                                @error('fecha_fin')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Número de huéspedes</label>
                                <input type="number" name="num_huespedes" class="form-input" required min="1" max="{{ $hospedaje->capacidad }}" value="{{ old('num_huespedes', 1) }}">
                                <p class="form-hint">Máximo: {{ $hospedaje->capacidad }} huéspedes</p>
                                @error('num_huespedes')<span class="form-error">{{ $message }}</span>@enderror
                            </div>

                            <button type="submit" class="btn-reserve">Reservar ahora</button>
                        </form>
                        <p class="booking-note">No se te cobrará todavía</p>
                    @else
                        <div class="login-box">
                            <p>Inicia sesión para reservar</p>
                            <a href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>
                            <p class="register-link">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <div style="height:60px;"></div>
</body>
</html>