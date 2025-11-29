<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva - Aloja.pe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #F5F7FA; }
        /* Navbar */
        .navbar { background: #2B4F9B; padding: 16px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .nav-container { max-width: 1120px; margin: 0 auto; padding: 0 24px; }
        .logo { font-size: 26px; font-weight: 700; color: white; text-decoration: none; }
        .logo .pe { color: #F5C344; }
        
        /* Container */
        .container { max-width: 720px; margin: 0 auto; padding: 40px 24px; }
        
        /* Back Link */
        .back-link { display: inline-flex; align-items: center; gap: 8px; color: #2B4F9B; text-decoration: none; font-weight: 600; margin-bottom: 24px; }
        .back-link:hover { gap: 12px; }
        
        /* Success Header */
        .success-header { text-align: center; margin-bottom: 32px; }
        .success-icon { font-size: 64px; margin-bottom: 16px; }
        .success-header h1 { font-size: 28px; font-weight: 700; color: #10B981; margin-bottom: 8px; }
        .success-header p { color: #6B7280; font-size: 16px; }
        
        /* Card */
        .card { background: white; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); padding: 32px; margin-bottom: 24px; }
        
        /* Confirmation Code */
        .confirmation-code { background: #D1FAE5; border: 2px solid #10B981; color: #065F46; padding: 16px; border-radius: 12px; text-align: center; font-size: 18px; font-weight: 700; margin-bottom: 32px; }
        
        /* Section */
        .section { margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid #E5E7EB; }
        .section:last-child { border: none; margin-bottom: 0; padding-bottom: 0; }
        .section-title { font-size: 18px; font-weight: 700; color: #1A1A1A; margin-bottom: 20px; }
        
        /* Hospedaje Info */
        .hospedaje-info { display: flex; gap: 16px; align-items: flex-start; padding: 16px; background: #F9FAFB; border-radius: 12px; }
        .hospedaje-img { width: 120px; height: 90px; border-radius: 8px; object-fit: cover; flex-shrink: 0; background: linear-gradient(135deg, #2B4F9B, #1e3a8a); display: flex; align-items: center; justify-content: center; color: white; font-size: 40px; }
        .hospedaje-details h3 { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
        .hospedaje-details p { font-size: 14px; color: #6B7280; }
        
        /* Details Grid */
        .details-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .detail-item { display: flex; flex-direction: column; gap: 4px; }
        .detail-label { font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; }
        .detail-value { font-size: 16px; font-weight: 600; color: #1A1A1A; }
        
        /* Price Breakdown */
        .price-row { display: flex; justify-content: space-between; padding: 12px 0; font-size: 15px; }
        .price-row.subtotal { color: #4B5563; }
        .price-row.total { padding-top: 16px; margin-top: 16px; border-top: 2px solid #E5E7EB; font-size: 18px; font-weight: 700; }
        /* Buttons */
        .actions { display: flex; flex-direction: column; gap: 12px; margin-top: 32px; }
        .btn { padding: 14px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center; transition: all 0.2s; border: none; cursor: pointer; font-size: 16px; }
        .btn-primary { background: #F5C344; color: #1A1A1A; }
        .btn-primary:hover { background: #E5B334; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(245,195,68,0.3); }
        .btn-secondary { background: #2B4F9B; color: white; }
        .btn-secondary:hover { background: #1e3a8a; }
        .btn-outline { background: white; color: #2B4F9B; border: 2px solid #2B4F9B; }
        .btn-outline:hover { background: #F5F7FA; }
        
        /* Info Box */
        .info-box { background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 16px; border-radius: 8px; margin-top: 24px; }
        .info-box strong { display: block; margin-bottom: 8px; color: #92400E; }
        .info-box ul { margin-left: 20px; color: #78350F; line-height: 1.8; }
        
        /* Responsive */
        @media (max-width: 640px) {
            .details-grid { grid-template-columns: 1fr; }
            .hospedaje-info { flex-direction: column; }
            .hospedaje-img { width: 100%; height: 180px; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">Aloja<span class="pe">.pe</span></a>
        </div>
    </nav>

    <!-- Container -->
    <div class="container">
        <a href="{{ route('home') }}" class="back-link">← Volver al hospedaje</a>
        <!-- Success Header -->
        <div class="success-header">
            <div class="success-icon">✅</div>
            <h1>¡Reserva Confirmada!</h1>
            <p>Revisa los detalles de tu reserva antes de continuar con el pago</p>
        </div>

        <!-- Confirmation Card -->
        <div class="card">
            <!-- Confirmation Code -->
            <div class="confirmation-code">
                📋 Código de Confirmación: #{{ str_pad($reserva->id_reserva, 6, '0', STR_PAD_LEFT) }}
            </div>
            <!-- Hospedaje Section -->
            <div class="section">
                <h2 class="section-title">Resumen de tu Reserva</h2>
                <div class="hospedaje-info">
                    @php
                        $foto = $reserva->hospedaje->fotos_galeria->first();
                    @endphp
                    @if($foto)
                        <img src="{{ asset('storage/' . $foto->ruta_foto) }}" alt="{{ $reserva->hospedaje->titulo }}" class="hospedaje-img">
                    @else
                        <div class="hospedaje-img">🏠</div>
                    @endif
                    <div class="hospedaje-details">
                        <h3>{{ $reserva->hospedaje->titulo }}</h3>
                        <p>📍 {{ $reserva->hospedaje->ubicacion }}</p>
                        <p style="margin-top: 8px;">👤 Anfitrión: {{ $reserva->hospedaje->anfitrion->nombre }} {{ $reserva->hospedaje->anfitrion->apellido }}</p>
                    </div>
                </div>
            </div>
            <!-- Details Section -->
            <div class="section">
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">📅 fech-Inicio</span>
                        <span class="detail-value">{{ $reserva->fecha_inicio->format('d/m/Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">📅 fech-Salida</span>
                        <span class="detail-value">{{ $reserva->fecha_fin->format('d/m/Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">👥 Huéspedes</span>
                        <span class="detail-value">{{ $reserva->num_huespedes }} {{ $reserva->num_huespedes == 1 ? 'persona' : 'personas' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">🌙 Noches</span>
                        <span class="detail-value">{{ $noches }} {{ $noches == 1 ? 'noche' : 'noches' }}</span>
                    </div>
                </div>
            </div>
            <!-- Price Section -->
            <div class="section">
                <h2 class="section-title">Resumen del Pedido</h2>
                <div class="price-row subtotal">
                    <span>S/. {{ number_format($reserva->hospedaje->precio, 2) }} x {{ $noches }} {{ $noches == 1 ? 'noche' : 'noches' }}</span>
                    <span>S/. {{ number_format($reserva->total, 2) }}</span>
                </div>
                <div class="price-row subtotal">
                    <span>Tarifa de servicio</span>
                    <span>S/. 25.00</span>
                </div>
                <div class="price-row total">
                    <span>Total a pagar</span>
                    <span>S/. {{ number_format($reserva->total + 25, 2) }}</span>
                </div>
            </div>
            <!-- Actions -->
            <div class="actions">
                <a href="{{ route('pagos.create', $reserva->id_reserva) }}" class="btn btn-primary">
                    Realizar Pago - S/. {{ number_format($reserva->total + 25, 2) }}
                </a>
                <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-secondary">
                    Ver Mis Reservas
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline">
                    Buscar Más Hospedajes
                </a>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <strong>Confirmación instantánea</strong>
                <ul>
                    <li>Tu reserva está confirmada</li>
                    <li><strong>Cancelación flexible</strong> hasta 24 horas antes del check-in</li>
                    <li>Soporte 24/7 disponible</li>
                </ul>
            </div>
        </div>
        <!-- Policy -->
        <div class="card">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 12px;">🛡️ Política de Cancelación Flexible</h3>
            <p style="color: #6B7280; line-height: 1.6; font-size: 14px;">
                Puedes cancelar tu reserva hasta 24 horas antes del check-in. Cancelaciones realizadas con más de 24 horas de anticipación recibirán reembolso completo. 
                Tu dinero está protegido.
            </p>
        </div>
    </div>
    <div style="height: 60px;"></div>
</body>
</html>