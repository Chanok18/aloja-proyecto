<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hospedaje->titulo }} - Aloja</title>
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
        .btn { padding: 12px 24px; border-radius: 5px; text-decoration: none; display: inline-block; font-weight: 600; }
        .btn-primary { background: #f59e0b; color: white; border: none; cursor: pointer; }
        .btn-secondary { background: #6b7280; color: white; border: none; }
        .btn-secondary:hover { background: #4b5563; }
        
        .back-btn { display: inline-block; margin: 20px 0; color: #1e3a8a; text-decoration: none; }
        .hero-image { width: 100%; height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 120px; margin-bottom: 30px; }
        
        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 30px; }
        .main-content { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .sidebar { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); position: sticky; top: 20px; }
        
        h1 { font-size: 32px; margin-bottom: 15px; color: #333; }
        .location { color: #666; font-size: 18px; margin-bottom: 20px; }
        .host-info { display: flex; align-items: center; gap: 15px; padding: 20px; background: #f9fafb; border-radius: 8px; margin-bottom: 30px; }
        .host-avatar { width: 60px; height: 60px; background: #1e3a8a; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; }
        
        .amenities-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin: 20px 0; }
        .amenity { display: flex; align-items: center; gap: 10px; padding: 10px; background: #f9fafb; border-radius: 5px; }
        
        .price-box { text-align: center; padding: 20px; background: #f9fafb; border-radius: 8px; margin-bottom: 20px; }
        .price { font-size: 36px; font-weight: bold; color: #1e3a8a; }
        .price small { font-size: 16px; color: #666; }
        
        .booking-form { margin-top: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px; }
        
        .reviews-section { margin-top: 40px; padding-top: 40px; border-top: 2px solid #e5e7eb; }
        .review-card { background: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 15px; }
        .review-header { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .stars { color: #f59e0b; font-size: 18px; }
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
        <a href="{{ route('home') }}" class="back-btn">← Volver a la búsqueda</a>

        <!-- Imagen Hero -->
        <div class="hero-image">🏠</div>

        <!-- Grid Principal -->
        <div class="content-grid">
            <!-- Contenido Principal -->
            <div class="main-content">
                <h1>{{ $hospedaje->titulo }}</h1>
                <div class="location">📍 {{ $hospedaje->ubicacion }}</div>

                <!-- Info del Anfitrión -->
                <div class="host-info">
                    <div class="host-avatar">{{ substr($hospedaje->anfitrion->nombre, 0, 1) }}</div>
                    <div>
                        <div style="font-weight: 600;">Anfitrión: {{ $hospedaje->anfitrion->nombre }} {{ $hospedaje->anfitrion->apellido }}</div>
                        <div style="color: #666; font-size: 14px;">Miembro desde {{ $hospedaje->anfitrion->created_at->format('Y') }}</div>
                    </div>
                </div>

                <!-- Detalles -->
                <div style="margin-bottom: 30px;">
                    <h2 style="margin-bottom: 15px;">Detalles del hospedaje</h2>
                    <div style="display: flex; gap: 30px; margin-bottom: 20px;">
                        <div>👥 <strong>Capacidad:</strong> {{ $hospedaje->capacidad }} personas</div>
                        <div>💰 <strong>Precio:</strong> S/. {{ number_format($hospedaje->precio, 2) }} por noche</div>
                    </div>
                </div>

                <!-- Descripción -->
                <div style="margin-bottom: 30px;">
                    <h2 style="margin-bottom: 15px;">Descripción</h2>
                    <p style="line-height: 1.8; color: #666;">
                        {{ $hospedaje->descripcion ?? 'El anfitrión no ha proporcionado una descripción detallada aún.' }}
                    </p>
                </div>

                <!-- Amenidades -->
                <div style="margin-bottom: 30px;">
                    <h2 style="margin-bottom: 15px;">Amenidades</h2>
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
                </div>

                <!-- Reseñas -->
                @if($hospedaje->resenas->count() > 0)
                    <div class="reviews-section">
                        <h2 style="margin-bottom: 20px;">
                            ⭐ {{ number_format($hospedaje->promedioCalificacion(), 1) }} 
                            ({{ $hospedaje->totalResenas() }} reseñas)
                        </h2>
                        
                        @foreach($hospedaje->resenas->take(5) as $resena)
                            <div class="review-card">
                                <div class="review-header">
                                    <div>
                                        <strong>{{ $resena->usuario->nombre }} {{ $resena->usuario->apellido }}</strong>
                                        <div style="color: #666; font-size: 14px;">{{ $resena->fecha_resena->diffForHumans() }}</div>
                                    </div>
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $resena->calificacion)
                                                ⭐
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p style="color: #666;">{{ $resena->comentario }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Sidebar de Reserva -->
            <div class="sidebar">
                <div class="price-box">
                    <div class="price">
                        S/. {{ number_format($hospedaje->precio, 0) }}
                        <small>/noche</small>
                    </div>
                </div>

                @auth
        <!-- Mensajes de error -->
        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Formulario de Reserva -->
        <form action="{{ route('reservas.store') }}" method="POST" class="booking-form">
            @csrf
            <input type="hidden" name="hospedaje_id" value="{{ $hospedaje->id_hospedaje }}">
        
            <div class="form-group">
                <label>Fecha de entrada</label>
                <input type="date" name="fecha_inicio" class="@error('fecha_inicio') border-red-500 @enderror" 
                    required min="{{ date('Y-m-d') }}" value="{{ old('fecha_inicio') }}">
                @error('fecha_inicio')
                    <small style="color: #ef4444;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Fecha de salida</label>
                <input type="date" name="fecha_fin" class="@error('fecha_fin') border-red-500 @enderror" 
                    required min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('fecha_fin') }}">
                @error('fecha_fin')
                    <small style="color: #ef4444;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Número de huéspedes</label>
                <input type="number" name="num_huespedes" class="@error('num_huespedes') border-red-500 @enderror" 
                    required min="1" max="{{ $hospedaje->capacidad }}" value="{{ old('num_huespedes', 1) }}">
                <small style="color: #666; font-size: 13px;">Máximo: {{ $hospedaje->capacidad }} huéspedes</small>
                @error('num_huespedes')
                    <small style="color: #ef4444; display: block;">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 16px;">
                Reservar ahora
            </button>
        </form>

                    <p style="text-align: center; margin-top: 15px; color: #666; font-size: 14px;">
                        No se te cobrará en este momento
                    </p>
                @else
                    <div style="text-align: center;">
                        <p style="margin-bottom: 15px; color: #666;">Inicia sesión para reservar</p>
                        <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; text-align: center;">
                            Iniciar Sesión
                        </a>
                        <p style="margin-top: 15px; font-size: 14px;">
                            ¿No tienes cuenta? 
                            <a href="{{ route('register') }}" style="color: #1e3a8a;">Regístrate</a>
                        </p>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div style="height: 50px;"></div>
</body>
</html>
