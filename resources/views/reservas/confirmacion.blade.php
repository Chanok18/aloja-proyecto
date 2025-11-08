<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Confirmada - Aloja</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        
        .header { background: #1e3a8a; color: white; padding: 20px 0; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .logo { font-size: 28px; font-weight: bold; text-align: center; }
        
        .success-card { background: white; border-radius: 12px; padding: 40px; margin-top: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; }
        .success-icon { font-size: 80px; margin-bottom: 20px; }
        h1 { color: #10b981; font-size: 32px; margin-bottom: 15px; }
        .confirmation-number { background: #f0fdf4; color: #10b981; padding: 15px; border-radius: 8px; font-size: 20px; font-weight: bold; margin: 20px 0; }
        
        .details-box { background: #f9fafb; padding: 25px; border-radius: 8px; margin: 30px 0; text-align: left; }
        .detail-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e5e7eb; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 600; color: #666; }
        .detail-value { color: #333; }
        
        .total-box { background: #1e3a8a; color: white; padding: 20px; border-radius: 8px; margin-top: 20px; }
        .total-label { font-size: 14px; opacity: 0.9; }
        .total-amount { font-size: 36px; font-weight: bold; margin-top: 5px; }
        
        .actions { display: flex; gap: 15px; margin-top: 30px; justify-content: center; }
        .btn { padding: 14px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block; }
        .btn-primary { background: #1e3a8a; color: white; }
        .btn-secondary { background: #e5e7eb; color: #333; }
        
        .info-message { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 5px; margin-top: 30px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="logo">🏠 Aloja</div>
        </div>
    </div>

    <div class="container">
        <div class="success-card">
            <div class="success-icon">✅</div>
            <h1>¡Reserva Confirmada!</h1>
            <p style="color: #666; font-size: 18px;">Tu reserva ha sido creada exitosamente</p>
            
            <div class="confirmation-number">
                📋 Código de Confirmación: #{{ str_pad($reserva->id_reserva, 6, '0', STR_PAD_LEFT) }}
            </div>

            <div class="details-box">
                <h3 style="margin-bottom: 20px; color: #333;">Detalles de tu Reserva</h3>
                
                <div class="detail-row">
                    <span class="detail-label">🏠 Hospedaje:</span>
                    <span class="detail-value">{{ $reserva->hospedaje->titulo }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">📍 Ubicación:</span>
                    <span class="detail-value">{{ $reserva->hospedaje->ubicacion }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">📅 Check-in:</span>
                    <span class="detail-value">{{ $reserva->fecha_inicio->format('d/m/Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">📅 Check-out:</span>
                    <span class="detail-value">{{ $reserva->fecha_fin->format('d/m/Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">🌙 Noches:</span>
                    <span class="detail-value">{{ $noches }} {{ $noches == 1 ? 'noche' : 'noches' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">👥 Huéspedes:</span>
                    <span class="detail-value">{{ $reserva->num_huespedes }} {{ $reserva->num_huespedes == 1 ? 'persona' : 'personas' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">👤 Anfitrión:</span>
                    <span class="detail-value">{{ $reserva->hospedaje->anfitrion->nombre }} {{ $reserva->hospedaje->anfitrion->apellido }}</span>
                </div>
            </div>

            <div class="total-box">
                <div class="total-label">Total a Pagar</div>
                <div class="total-amount">S/. {{ number_format($reserva->total, 2) }}</div>
                <div style="font-size: 14px; margin-top: 5px; opacity: 0.9;">
                    (S/. {{ number_format($reserva->hospedaje->precio, 2) }} × {{ $noches }} {{ $noches == 1 ? 'noche' : 'noches' }})
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('pagos.create', $reserva->id_reserva) }}" class="btn btn-primary">
                    💳 Proceder al Pago
                </a>
                <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-secondary">
                    Ver Mis Reservas
                </a>
                <a href="{{ route('hospedajes.publico.index') }}" class="btn btn-secondary">
                    Buscar Más Hospedajes
                </a>
            </div>

            <div class="info-message">
                <strong>ℹ️ Próximos pasos:</strong><br>
                • Tu reserva está en estado <strong>PENDIENTE</strong><br>
                • El anfitrión debe confirmarla próximamente<br>
                • Recibirás una notificación cuando sea confirmada<br>
                • Podrás realizar el pago una vez confirmada
            </div>
        </div>
    </div>

    <div style="height: 50px;"></div>
</body>
</html>
