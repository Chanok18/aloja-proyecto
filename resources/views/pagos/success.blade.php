<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso - Aloja</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        
        .container { max-width: 700px; margin: 20px; }
        
        .success-card { background: white; border-radius: 16px; padding: 50px 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); text-align: center; }
        
        .success-icon { font-size: 100px; margin-bottom: 20px; animation: bounce 1s ease; }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        h1 { color: #10b981; font-size: 36px; margin-bottom: 10px; }
        .subtitle { color: #666; font-size: 18px; margin-bottom: 30px; }
        
        .transaction-info { background: #f0fdf4; border: 2px dashed #10b981; padding: 20px; border-radius: 8px; margin: 30px 0; }
        .transaction-number { font-size: 20px; font-weight: bold; color: #065f46; margin-bottom: 10px; }
        .transaction-date { color: #666; font-size: 14px; }
        
        .details-box { background: #f9fafb; padding: 25px; border-radius: 8px; margin: 30px 0; text-align: left; }
        .detail-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e5e7eb; }
        .detail-row:last-child { border-bottom: none; }
        
        .payment-amount { background: #1e3a8a; color: white; padding: 25px; border-radius: 8px; margin: 20px 0; }
        .amount-label { font-size: 14px; opacity: 0.9; }
        .amount-value { font-size: 42px; font-weight: bold; margin: 10px 0; }
        
        .actions { display: flex; gap: 15px; margin-top: 30px; }
        .btn { padding: 16px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; flex: 1; display: inline-block; text-align: center; }
        .btn-primary { background: #1e3a8a; color: white; }
        .btn-secondary { background: #e5e7eb; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-card">
            <div class="success-icon">🎉</div>
            <h1>¡Pago Exitoso!</h1>
            <p class="subtitle">Tu reserva ha sido confirmada</p>

            <div class="transaction-info">
                <div class="transaction-number">
                    🔖 Número de Transacción:<br>
                    {{ $pago->referencia_pago }}
                </div>
                <div class="transaction-date">
                    Procesado el {{ $pago->fecha_pago->format('d/m/Y H:i:s') }}
                </div>
            </div>

            <div class="payment-amount">
                <div class="amount-label">Monto Pagado</div>
                <div class="amount-value">S/. {{ number_format($pago->monto, 2) }}</div>
                <div style="font-size: 14px; opacity: 0.9;">
                    Método: {{ ucfirst($pago->metodo) }}
                </div>
            </div>

            <div class="details-box">
                <h3 style="margin-bottom: 15px; color: #333;">📋 Detalles de la Reserva</h3>
                
                <div class="detail-row">
                    <span>Código de Reserva:</span>
                    <strong>#{{ str_pad($pago->reserva->id_reserva, 6, '0', STR_PAD_LEFT) }}</strong>
                </div>
                
                <div class="detail-row">
                    <span>Hospedaje:</span>
                    <strong>{{ $pago->reserva->hospedaje->titulo }}</strong>
                </div>
                
                <div class="detail-row">
                    <span>Check-in:</span>
                    <span>{{ $pago->reserva->fecha_inicio->format('d/m/Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span>Check-out:</span>
                    <span>{{ $pago->reserva->fecha_fin->format('d/m/Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span>Noches:</span>
                    <span>{{ $noches }}</span>
                </div>
                
                <div class="detail-row">
                    <span>Huéspedes:</span>
                    <span>{{ $pago->reserva->num_huespedes }}</span>
                </div>

                <div class="detail-row">
                    <span>Estado:</span>
                    <span style="color: #10b981; font-weight: bold;">✅ CONFIRMADA</span>
                </div>
            </div>

            <div style="background: #dbeafe; padding: 15px; border-radius: 8px; margin: 20px 0; font-size: 14px; text-align: left;">
                <strong>📧 Próximos pasos:</strong><br>
                • Recibirás un correo de confirmación (simulado)<br>
                • El anfitrión ha sido notificado<br>
                • Puedes contactar al anfitrión antes del check-in<br>
                • Recuerda llegar a la hora acordada
            </div>

            <div class="actions">
                <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-primary">
                    Ver Mis Reservas
                </a>
                <a href="{{ route('hospedajes.publico.index') }}" class="btn btn-secondary">
                    Buscar Más
                </a>
            </div>
        </div>
    </div>
</body>
</html>