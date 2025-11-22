<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Reserva - Aloja</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        
        .header { background: #1e3a8a; color: white; padding: 20px 0; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .logo { font-size: 28px; font-weight: bold; text-align: center; }
        
        .payment-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px; }
        
        .payment-card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        
        h1 { color: #1e3a8a; font-size: 28px; margin-bottom: 10px; }
        .subtitle { color: #666; margin-bottom: 25px; }
        
        .reservation-summary { background: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 25px; }
        .summary-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
        .summary-row:last-child { border-bottom: none; }
        .total-row { background: #1e3a8a; color: white; margin: 15px -20px -20px -20px; padding: 18px 20px; border-radius: 0 0 8px 8px; font-weight: bold; font-size: 20px; }
        
        .payment-methods { margin: 25px 0; }
        .method-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 15px; }
        .method-option { position: relative; }
        .method-option input[type="radio"] { position: absolute; opacity: 0; }
        .method-label { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            padding: 20px; 
            border: 2px solid #e5e7eb; 
            border-radius: 8px; 
            cursor: pointer; 
            transition: all 0.3s;
            background: white;
        }
        .method-option input[type="radio"]:checked + .method-label { 
            border-color: #1e3a8a; 
            background: #eff6ff; 
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }
        .method-icon { font-size: 40px; margin-bottom: 8px; }
        .method-name { font-weight: 600; color: #333; font-size: 15px; }
        
        .payment-details { 
            display: none; 
            background: #f9fafb; 
            padding: 25px; 
            border-radius: 8px; 
            margin-top: 20px;
            border: 2px solid #e5e7eb;
        }
        .payment-details.active { display: block; }
        
        .qr-container { text-align: center; }
        .qr-placeholder { 
            width: 250px; 
            height: 250px; 
            background: white; 
            border: 3px solid #1e3a8a; 
            border-radius: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 20px auto;
            font-size: 80px;
        }
        .qr-info { 
            background: white; 
            padding: 15px; 
            border-radius: 8px; 
            margin-top: 15px;
            border-left: 4px solid #1e3a8a;
        }
        .qr-info strong { display: block; margin-bottom: 8px; color: #1e3a8a; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #333; }
        .form-group input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #d1d5db; 
            border-radius: 6px; 
            font-size: 15px;
        }
        .form-row { display: grid; grid-template-columns: 2fr 1fr; gap: 15px; }
        
        .security-note { 
            background: #fef3c7; 
            border-left: 4px solid #f59e0b; 
            padding: 15px; 
            border-radius: 5px; 
            margin: 20px 0;
            font-size: 14px;
        }
        
        .btn { padding: 16px 32px; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; border: none; transition: all 0.3s; }
        .btn-primary { background: #1e3a8a; color: white; width: 100%; }
        .btn-primary:hover { background: #1e40af; transform: translateY(-2px); }
        .btn-secondary { background: #e5e7eb; color: #333; text-decoration: none; display: inline-block; text-align: center; }
        
        .error-message { background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid #dc2626; }
        
        @media (max-width: 768px) {
            .payment-wrapper { grid-template-columns: 1fr; }
            .method-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="logo">🏠 Aloja</div>
        </div>
    </div>

    <div class="container">
        <div class="payment-wrapper">
            
            <!-- COLUMNA IZQUIERDA: Resumen -->
            <div>
                <div class="payment-card">
                    <h1>💳 Realizar Pago</h1>
                    <p class="subtitle">Estás a un paso de confirmar tu reserva</p>

                    <!-- Resumen de la Reserva -->
                    <div class="reservation-summary">
                        <h3 style="margin-bottom: 15px; color: #333;">📋 Resumen de Reserva</h3>
                        
                        <div class="summary-row">
                            <span>Hospedaje:</span>
                            <span><strong>{{ $reserva->hospedaje->titulo }}</strong></span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Ubicación:</span>
                            <span>{{ $reserva->hospedaje->ubicacion }}</span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Check-in:</span>
                            <span>{{ $reserva->fecha_inicio->format('d/m/Y') }}</span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Check-out:</span>
                            <span>{{ $reserva->fecha_fin->format('d/m/Y') }}</span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Noches:</span>
                            <span>{{ $noches }}</span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Huéspedes:</span>
                            <span>{{ $reserva->num_huespedes }}</span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Precio por noche:</span>
                            <span>S/. {{ number_format($reserva->hospedaje->precio, 2) }}</span>
                        </div>
                        
                        <div class="total-row">
                            <div style="display: flex; justify-content: space-between;">
                                <span>Total a Pagar:</span>
                                <span>S/. {{ number_format($reserva->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="security-note">
                        <strong>🔒 Pago Seguro Simulado</strong><br>
                        Este es un entorno de prueba educativo. No se procesará ningún cargo real.
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA: Métodos de Pago -->
            <div>
                <div class="payment-card">
                    <h3 style="margin-bottom: 10px; color: #333;">Método de Pago</h3>
                    <p style="color: #666; font-size: 14px; margin-bottom: 20px;">Selecciona cómo deseas pagar</p>

                    @if(session('error'))
                        <div class="error-message">
                            ❌ {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('pagos.store') }}" method="POST" id="paymentForm">
                        @csrf
                        <input type="hidden" name="reserva_id" value="{{ $reserva->id_reserva }}">

                        <div class="payment-methods">
                            <div class="method-grid">
                                <div class="method-option">
                                    <input type="radio" name="metodo_pago" id="yape" value="yape" required>
                                    <label for="yape" class="method-label">
                                        <div class="method-icon">💜</div>
                                        <div class="method-name">Yape</div>
                                    </label>
                                </div>

                                <div class="method-option">
                                    <input type="radio" name="metodo_pago" id="plin" value="plin">
                                    <label for="plin" class="method-label">
                                        <div class="method-icon">💚</div>
                                        <div class="method-name">Plin</div>
                                    </label>
                                </div>

                                <div class="method-option">
                                    <input type="radio" name="metodo_pago" id="tarjeta" value="tarjeta">
                                    <label for="tarjeta" class="method-label">
                                        <div class="method-icon">💳</div>
                                        <div class="method-name">Tarjeta</div>
                                    </label>
                                </div>

                                <div class="method-option">
                                    <input type="radio" name="metodo_pago" id="paypal" value="paypal">
                                    <label for="paypal" class="method-label">
                                        <div class="method-icon">🅿️</div>
                                        <div class="method-name">PayPal</div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- DETALLES DE YAPE -->
                        <div class="qr-placeholder" style="padding: 0; overflow: hidden; background: white;">
                            @if(file_exists(public_path('images/qr-yape.png')))
                                <img src="{{ asset('images/qr-yape.png') }}" alt="QR Yape Aloja" 
                                    style="width: 100%; height: 100%; object-fit: contain;">
                            @else
                                <span style="font-size: 60px;">📱</span>
                                <p style="font-size: 14px; color: #999; margin-top: 10px;">QR no disponible</p>
                            @endif
                        </div>
                                <div class="qr-info">
                                    <strong>Instrucciones:</strong>
                                    <p style="color: #666; line-height: 1.6;">
                                        1. Abre tu app Yape<br>
                                        2. Escanea el código QR<br>
                                        3. Confirma el monto: <strong style="color: #722F87;">S/. {{ number_format($reserva->total, 2) }}</strong><br>
                                        4. Click en "Confirmar Pago" abajo
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- DETALLES DE PLIN -->
                        <div class="qr-placeholder" style="padding: 0; overflow: hidden; background: white;">
                            @if(file_exists(public_path('images/qr-plin.png')))
                                <img src="{{ asset('images/qr-plin.png') }}" alt="QR Plin Aloja" 
                                    style="width: 100%; height: 100%; object-fit: contain;">
                            @else
                                <span style="font-size: 60px;">📲</span>
                                <p style="font-size: 14px; color: #999; margin-top: 10px;">QR no disponible</p>
                            @endif
                        </div>
                                <div class="qr-info">
                                    <strong>Instrucciones:</strong>
                                    <p style="color: #666; line-height: 1.6;">
                                        1. Abre tu app de banco con Plin<br>
                                        2. Escanea el código QR<br>
                                        3. Verifica el monto: <strong style="color: #00A19B;">S/. {{ number_format($reserva->total, 2) }}</strong><br>
                                        4. Click en "Confirmar Pago" abajo
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- DETALLES DE TARJETA -->
                        <div id="tarjetaDetails" class="payment-details">
                            <h4 style="color: #1e3a8a; margin-bottom: 15px;">💳 Pago con Tarjeta</h4>
                            
                            <div class="form-group">
                                <label>Número de Tarjeta</label>
                                <input type="text" placeholder="1234 5678 9012 3456" maxlength="19">
                            </div>

                            <div class="form-group">
                                <label>Nombre en la Tarjeta</label>
                                <input type="text" placeholder="NOMBRE APELLIDO">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Fecha de Expiración</label>
                                    <input type="text" placeholder="MM/AA" maxlength="5">
                                </div>
                                <div class="form-group">
                                    <label>CVV</label>
                                    <input type="text" placeholder="123" maxlength="3">
                                </div>
                            </div>

                            <p style="color: #666; font-size: 13px; margin-top: 10px;">
                                🔒 Tus datos están protegidos con encriptación SSL
                            </p>
                        </div>

                        <!-- DETALLES DE PAYPAL -->
                        <div id="paypalDetails" class="payment-details">
                            <div style="text-align: center;">
                                <h4 style="color: #0070ba; margin-bottom: 15px;">🅿️ Pago con PayPal</h4>
                                <div style="background: white; padding: 30px; border-radius: 8px; margin: 20px 0;">
                                    <div style="font-size: 60px; margin-bottom: 15px;">🌐</div>
                                    <p style="color: #666; margin-bottom: 20px;">
                                        Serás redirigido a PayPal para completar tu pago de manera segura
                                    </p>
                                    <div style="background: #0070ba; color: white; padding: 12px 24px; border-radius: 25px; display: inline-block; font-weight: bold;">
                                        PayPal Checkout
                                    </div>
                                </div>
                                <p style="color: #666; font-size: 13px;">
                                    Monto a pagar: <strong style="color: #0070ba;">S/. {{ number_format($reserva->total, 2) }}</strong>
                                </p>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="margin-top: 25px;">
                            ✅ Confirmar Pago de S/. {{ number_format($reserva->total, 2) }}
                        </button>

                        <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-secondary" style="width: 100%; margin-top: 15px;">
                            ← Cancelar y Volver
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div style="height: 50px;"></div>

    <script>
        // JavaScript para mostrar/ocultar detalles según método seleccionado
        document.addEventListener('DOMContentLoaded', function() {
            const metodos = document.querySelectorAll('input[name="metodo_pago"]');
            const detalles = {
                'yape': document.getElementById('yapeDetails'),
                'plin': document.getElementById('plinDetails'),
                'tarjeta': document.getElementById('tarjetaDetails'),
                'paypal': document.getElementById('paypalDetails')
            };

            metodos.forEach(metodo => {
                metodo.addEventListener('change', function() {
                    // Ocultar todos los detalles
                    Object.values(detalles).forEach(detalle => {
                        detalle.classList.remove('active');
                    });

                    // Mostrar el detalle del método seleccionado
                    if (detalles[this.value]) {
                        detalles[this.value].classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>