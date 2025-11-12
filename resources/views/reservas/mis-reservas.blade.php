<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas - Aloja</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        
        .header { background: #1e3a8a; color: white; padding: 20px 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 28px; font-weight: bold; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; }
        
        .page-title { margin: 30px 0; font-size: 32px; color: #333; }
        
        .reserva-card { background: white; border-radius: 8px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .reserva-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px; }
        .reserva-title { font-size: 22px; color: #1e3a8a; margin-bottom: 5px; }
        .reserva-location { color: #666; font-size: 16px; }
        
        .estado-badge { padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600; }
        .estado-pendiente { background: #fef3c7; color: #92400e; }
        .estado-confirmada { background: #d1fae5; color: #065f46; }
        .estado-cancelada { background: #fee2e2; color: #991b1b; }
        .estado-completada { background: #dbeafe; color: #1e40af; }
        
        .reserva-details { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .detail-item { display: block;}
        .detail-label { font-size: 14px; color: #666; margin-bottom: 5px; }
        .detail-value { font-size: 16px; font-weight: 600; color: #333; }
        
        .reserva-footer { display: flex; justify-content: space-between; align-items: center; padding-top: 20px; border-top: 1px solid #e5e7eb; }
        .precio-total { font-size: 24px; font-weight: bold; color: #1e3a8a; }
        
        .btn { padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-block; border: none; cursor: pointer; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-primary { background: #1e3a8a; color: white; }
        
        .empty-state { text-align: center; padding: 60px 20px; background: white; border-radius: 8px; }
        .empty-icon { font-size: 80px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">🏠 Aloja</div>
                <div class="nav-links">
                    <a href="{{ route('home') }}">Buscar Hospedajes</a>
                    <a href="{{ route('dashboard') }}">Mi Panel</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="page-title">📋 Mis Reservas</h1>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if($reservas->count() > 0)
            @foreach($reservas as $reserva)
                <div class="reserva-card">
                    <div class="reserva-header">
                        <div>
                            <h3 class="reserva-title">{{ $reserva->hospedaje->titulo }}</h3>
                            <div class="reserva-location">📍 {{ $reserva->hospedaje->ubicacion }}</div>
                        </div>
                        <span class="estado-badge estado-{{ $reserva->estado }}">
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
                    </div>

                    <div class="reserva-details">
                        <div class="detail-item">
                            <div class="detail-label">Check-in</div>
                            <div class="detail-value">📅 {{ $reserva->fecha_inicio->format('d/m/Y') }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Check-out</div>
                            <div class="detail-value">📅 {{ $reserva->fecha_fin->format('d/m/Y') }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Noches</div>
                            <div class="detail-value">🌙 {{ $reserva->diasReservados() }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Huéspedes</div>
                            <div class="detail-value">👥 {{ $reserva->num_huespedes }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Reservado el</div>
                            <div class="detail-value">📆 {{ $reserva->created_at->format('d/m/Y') }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Código</div>
                            <div class="detail-value">#{{ str_pad($reserva->id_reserva, 6, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>

                    <div class="reserva-footer">
                        <div class="precio-total">
                            Total: S/. {{ number_format($reserva->total, 2) }}
                        </div>
                        <div>
                            @if($reserva->estaPendiente())
                                <form action="{{ route('reservas.cancelar', $reserva->id_reserva) }}" method="POST" style="display: inline;" 
                                      onsubmit="return confirm('¿Seguro que deseas cancelar esta reserva?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Cancelar Reserva</button>
                                </form>
                            @endif
                            <a href="{{ route('hospedajes.publico.show', $reserva->hospedaje->id_hospedaje) }}" class="btn btn-primary">
                                Ver Hospedaje
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h2 style="color: #666; margin-bottom: 10px;">No tienes reservas aún</h2>
                <p style="color: #999; margin-bottom: 30px;">Explora hospedajes y haz tu primera reserva</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    Buscar Hospedajes
                </a>
            </div>
        @endif
    </div>

    <div style="height: 50px;"></div>
</body>
</html>