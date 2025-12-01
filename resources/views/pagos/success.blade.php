<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso - Aloja.pe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        
        /* Modal */
        .modal { background: white; border-radius: 20px; max-width: 480px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: slideUp 0.4s ease-out; position: relative; }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        
        .close-btn { position: absolute; top: 16px; right: 16px; background: #F3F4F6; border: none; border-radius: 50%; width: 32px; height: 32px; cursor: pointer; font-size: 18px; color: #6B7280; transition: all 0.2s; }
        .close-btn:hover { background: #E5E7EB; transform: rotate(90deg); }
        
        /* Header */
        .modal-header { text-align: center; padding: 40px 32px 24px; }
        .success-icon { width: 80px; height: 80px; background: linear-gradient(135deg, #F5C344 0%, #E5B334 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 40px; box-shadow: 0 8px 24px rgba(245,195,68,0.3); }
        .modal-header h1 { font-size: 24px; font-weight: 700; color: #1A1A1A; margin-bottom: 8px; }
        .modal-header p { font-size: 15px; color: #6B7280; }
        
        /* Reservation Code */
        .reservation-code { background: #EFF6FF; border: 2px solid #2B4F9B; padding: 16px; margin: 0 32px 24px; border-radius: 12px; text-align: center; }
        .reservation-code .label { font-size: 12px; font-weight: 600; color: #2B4F9B; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .reservation-code .code { font-size: 20px; font-weight: 700; color: #2B4F9B; letter-spacing: 1px; }
        
        /* Content */
        .modal-content { padding: 0 32px 32px; }
        
        /* Info Section */
        .info-section { background: #F9FAFB; padding: 20px; border-radius: 12px; margin-bottom: 24px; }
        .info-row { display: flex; align-items: center; gap: 12px; padding: 10px 0; }
        .info-row:not(:last-child) { border-bottom: 1px solid #E5E7EB; }
        .info-icon { font-size: 20px; width: 32px; text-align: center; }
        .info-text { flex: 1; }
        .info-label { font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; display: block; margin-bottom: 2px; }
        .info-value { font-size: 15px; font-weight: 600; color: #1A1A1A; }
        
        /* Details List */
        .details-list { background: #F9FAFB; padding: 20px; border-radius: 12px; margin-bottom: 24px; }
        .detail-item { display: flex; justify-content: space-between; padding: 10px 0; font-size: 14px; }
        .detail-item:not(:last-child) { border-bottom: 1px solid #E5E7EB; }
        .detail-label { color: #6B7280; }
        .detail-value { font-weight: 600; color: #1A1A1A; }
        
        /* Actions */
        .modal-actions { display: flex; flex-direction: column; gap: 10px; }
        .btn { padding: 14px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center; font-size: 15px; transition: all 0.2s; border: none; cursor: pointer; }
        .btn-primary { background: #2B4F9B; color: white; }
        .btn-primary:hover { background: #1e3a8a; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(43,79,155,0.3); }
        .btn-secondary { background: #F3F4F6; color: #1A1A1A; }
        .btn-secondary:hover { background: #E5E7EB; }
        
        /* Footer Note */
        .footer-note { background: #FEF3C7; padding: 16px; border-radius: 8px; margin-top: 20px; font-size: 13px; line-height: 1.6; color: #78350F; }
        .footer-note strong { display: block; margin-bottom: 6px; color: #92400E; }
        
        @media (max-width: 640px) {
            .modal { margin: 0; border-radius: 16px; }
            .modal-header { padding: 32px 24px 20px; }
            .modal-content { padding: 0 24px 24px; }
            .reservation-code { margin: 0 24px 20px; }
        }
    </style>
</head>
<body>
    <div class="modal">
        <button class="close-btn" onclick="window.location.href='{{ route('home') }}'">×</button>
        
        <!-- Header -->
        <div class="modal-header">
            <div class="success-icon">✓</div>
            <h1>¡Reserva Confirmada!</h1>
            <p>Tu pago se ha procesado exitosamente</p>
        </div>

        <!-- Reservation Code -->
        <div class="reservation-code">
            <div class="label">Número de Reserva</div>
            <div class="code">ALJ-{{ strtoupper(substr(md5($pago->reserva->id_reserva), 0, 8)) }}</div>
        </div>

        <!-- Content -->
        <div class="modal-content">
            <!-- Hospedaje Info -->
            <div class="info-section">
                <div class="info-row">
                    <div class="info-icon">🏠</div>
                    <div class="info-text">
                        <span class="info-label">Hospedaje</span>
                        <div class="info-value">{{ $pago->reserva->hospedaje->titulo }}</div>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-icon">📅</div>
                    <div class="info-text">
                        <span class="info-label">Fechas</span>
                        <div class="info-value">
                            {{ $pago->reserva->fecha_inicio->format('d M Y') }} - {{ $pago->reserva->fecha_fin->format('d M Y') }}
                        </div>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-icon">👥</div>
                    <div class="info-text">
                        <span class="info-label">Huéspedes</span>
                        <div class="info-value">{{ $pago->reserva->num_huespedes }} {{ $pago->reserva->num_huespedes == 1 ? 'persona' : 'personas' }}</div>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="details-list">
                <div class="detail-item">
                    <span class="detail-label">Método de pago</span>
                    <span class="detail-value">{{ ucfirst($pago->metodo) }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Monto pagado</span>
                    <span class="detail-value">S/. {{ number_format($pago->monto, 2) }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">N° de transacción</span>
                    <span class="detail-value" style="font-size: 12px;">{{ $pago->referencia_pago }}</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="modal-actions">
                <a href="{{ route('home') }}" class="btn btn-primary">Volver al Inicio</a>
                <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-secondary">Ver mis Reservas</a>
            </div>

            <!-- Footer Note -->
            <div class="footer-note">
                <strong>📧 Hemos enviado los detalles a tu correo electrónico</strong>
                • Confirmación instantánea<br>
                • Cancelación flexible<br>
                • Soporte 24/7
            </div>
        </div>
    </div>

    <script>
        // Auto-cerrar después de 10 segundos (opcional)
        // setTimeout(() => { window.location.href = '{{ route('home') }}'; }, 10000);
    </script>
</body>
</html>