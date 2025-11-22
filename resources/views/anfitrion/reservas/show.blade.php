<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Reserva - Aloja</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        
        .header { background: #1e3a8a; color: white; padding: 20px 0; }
        .container { max-width: 1000px; margin: 0 auto; padding: 0 20px; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 28px; font-weight: bold; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; }
        
        .back-btn { display: inline-block; margin: 20px 0; color: #1e3a8a; text-decoration: none; font-weight: 600; }
        
        .detail-card { background: white; border-radius: 12px; padding: 40px; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        
        .status-banner { padding: 20px; border-radius: 8px; margin-bottom: 30px; text-align: center; font-size: 18px; font-weight: 600; }
        .status-pendiente { background: #fef3c7; color: #92400e; }
        .status-confirmada { background: #d1fae5; color: #065f46; }
        .status-cancelada { background: #fee2e2; color: #991b1b; }
        
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; margin: 30px 0; }
        .info-section h3 { color: #1e3a8a; margin-bottom: 15px; font-size: 18px; }
        .info-item { padding: 12px 0; border-bottom: 1px solid #e5e7eb; }
        .info-item:last-child { border-bottom: none; }
        .info-label { color: #666; font-size: 14px; margin-bottom: 5px; }
        .info-value { color: #333; font-weight: 600; font-size: 16px; }
        
        .total-box { background: #1e3a8a; color: white; padding: 30px; border-radius: 8px; text-align: center; margin-top: 30px; }
        .total-label { font-size: 16px; opacity: 0.9; }
        .total-amount { font-size: 48px; font-weight: bold; margin: 10px 0; }
        
        .btn { padding: 12px 24px; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-block; }
        .btn-primary { background: #1e3a8a; color: white; }
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
        <a href="{{ route('anfitrion.reservas.index') }}" class="back-btn">← Volver a Reservas</a>

        <div class="detail-card">
            <h1 style="color: #1e3a8a; margin-bottom: 10px;">Reserva #{{ str_pad($reserva->id_reserva, 6, '0', STR_PAD_LEFT) }}</h1>
            <p style="color: #666; margin-bottom: 30px;">Creada el {{ $reserva->created_at->format('d/m/Y H:i') }}</p>

            <!-- Estado -->
            <div class="status-banner status-{{ $reserva->estado }}">
                @if($reserva->estado == 'pendiente')
                    ⏳ RESERVA PENDIENTE DE PAGO
                @elseif($reserva->estado == 'confirmada')
                    ✅ RESERVA CONFIRMADA Y PAGADA
                @elseif($reserva->estado == 'cancelada')
                    ❌ RESERVA CANCELADA
                @else
                    ✔️ RESERVA COMPLETADA
                @endif
            </div>

            <!-- Información -->
            <div class="info-grid">
                <!-- Información del Viajero -->
                <div class="info-section">
                    <h3>👤 Información del Viajero</h3>
                    <div class="info-item">
                        <div class="info-label">Nombre completo</div>
                        <div class="info-value">{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Correo electrónico</div>
                        <div class="info-value">{{ $reserva->usuario->correo }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Teléfono</div>
                        <div class="info-value">{{ $reserva->usuario->telefono }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Número de huéspedes</div>
                        <div class="info-value">{{ $reserva->num_huespedes }} {{ $reserva->num_huespedes == 1 ? 'persona' : 'personas' }}</div>
                    </div>
                </div>

                <!-- Información del Hospedaje -->
                <div class="info-section">
                    <h3>🏠 Información del Hospedaje</h3>
                    <div class="info-item">
                        <div class="info-label">Propiedad</div>
                        <div class="info-value">{{ $reserva->hospedaje->titulo }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ubicación</div>
                        <div class="info-value">{{ $reserva->hospedaje->ubicacion }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Capacidad máxima</div>
                        <div class="info-value">{{ $reserva->hospedaje->capacidad }} personas</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Precio por noche</div>
                        <div class="info-value">S/. {{ number_format($reserva->hospedaje->precio, 2) }}</div>
                    </div>
                </div>
            </div>

            <!-- Fechas -->
            <div class="info-section" style="margin-top: 30px;">
                <h3>📅 Fechas de Estadía</h3>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 15px;">
                    <div style="background: #f9fafb; padding: 20px; border-radius: 8px; text-align: center;">
                        <div style="color: #666; font-size: 14px; margin-bottom: 5px;">Check-in</div>
                        <div style="font-size: 24px; font-weight: bold; color: #1e3a8a;">{{ $reserva->fecha_inicio->format('d/m/Y') }}</div>
                    </div>
                    <div style="background: #f9fafb; padding: 20px; border-radius: 8px; text-align: center;">
                        <div style="color: #666; font-size: 14px; margin-bottom: 5px;">Check-out</div>
                        <div style="font-size: 24px; font-weight: bold; color: #1e3a8a;">{{ $reserva->fecha_fin->format('d/m/Y') }}</div>
                    </div>
                    <div style="background: #f9fafb; padding: 20px; border-radius: 8px; text-align: center;">
                        <div style="color: #666; font-size: 14px; margin-bottom: 5px;">Noches</div>
                        <div style="font-size: 24px; font-weight: bold; color: #1e3a8a;">{{ $noches }}</div>
                    </div>
                </div>
            </div>

            <!-- Información de Pago -->
            @if($reserva->pago)
                <div class="info-section" style="margin-top: 30px;">
                    <h3>💳 Información del Pago</h3>
                    <div style="background: #f0fdf4; border: 2px solid #10b981; padding: 20px; border-radius: 8px; margin-top: 15px;">
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                            <div>
                                <div style="color: #666; font-size: 14px;">Método de pago</div>
                                <div style="font-weight: 600; color: #065f46;">{{ ucfirst($reserva->pago->metodo) }}</div>
                            </div>
                            <div>
                                <div style="color: #666; font-size: 14px;">Referencia</div>
                                <div style="font-weight: 600; color: #065f46;">{{ $reserva->pago->referencia_pago }}</div>
                            </div>
                            <div>
                                <div style="color: #666; font-size: 14px;">Fecha de pago</div>
                                <div style="font-weight: 600; color: #065f46;">{{ $reserva->pago->fecha_pago->format('d/m/Y H:i') }}</div>
                            </div>
                            <div>
                                <div style="color: #666; font-size: 14px;">Estado</div>
                                <div style="font-weight: 600; color: #10b981;">✅ {{ ucfirst($reserva->pago->estado_pago) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div style="background: #fef3c7; border: 2px solid #f59e0b; padding: 20px; border-radius: 8px; margin-top: 30px; text-align: center;">
                    <strong>⚠️ Esta reserva aún no ha sido pagada</strong>
                </div>
            @endif

            <!-- Total -->
            <div class="total-box">
                <div class="total-label">Monto Total</div>
                <div class="total-amount">S/. {{ number_format($reserva->total, 2) }}</div>
                <div style="font-size: 14px; opacity: 0.9;">
                    (S/. {{ number_format($reserva->hospedaje->precio, 2) }} × {{ $noches }} {{ $noches == 1 ? 'noche' : 'noches' }})
                </div>
            </div>

            <!-- Botones -->
            <div style="margin-top: 30px; text-align: center;">
                <a href="{{ route('anfitrion.reservas.index') }}" class="btn btn-primary">
                    Volver a Reservas
                </a>
                <a href="{{ route('anfitrion.hospedajes.show', $reserva->hospedaje->id_hospedaje) }}" class="btn btn-primary" style="background: #6b7280;">
                    Ver Hospedaje
                </a>
            </div>
        </div>
    </div>

    <div style="height: 50px;"></div>
</body>
</html>