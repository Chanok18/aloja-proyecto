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
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        .logo { font-size: 28px; font-weight: bold; text-align: center; }
        
        .payment-card { background: white; border-radius: 12px; padding: 40px; margin-top: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        
        h1 { color: #1e3a8a; font-size: 28px; margin-bottom: 10px; text-align: center; }
        .subtitle { text-align: center; color: #666; margin-bottom: 30px; }
        
        .reservation-summary { background: #f9fafb; padding: 25px; border-radius: 8px; margin-bottom: 30px; }
        .summary-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e5e7eb; }
        .summary-row:last-child { border-bottom: none; font-weight: bold; font-size: 18px; }
        
        .payment-methods { margin: 30px 0; }
        .method-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-top: 20px; }
        .method-option { position: relative; }
        .method-option input[type="radio"] { position: absolute; opacity: 0; }
        .method-label { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            padding: 25px; 
            border: 2px solid #e5e7eb; 
            border-radius: 8px; 
            cursor: pointer; 
            transition: all 0.3s;
            background: white;
        }
        .method-option input[type="radio"]:checked + .method-label { 
            border-color: #1e3a8a; 
            background: #eff6ff; 
        }
        .method-icon { font-size: 48px; margin-bottom: 10px; }
        .method-name { font-weight: 600; color: #333; }
        
        .security-note { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 5px; margin: 20px 0; }
        
        .btn { padding: 16px 32px; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; border: none; }
        .btn-primary { background: #1e3a8a; color: white; width: 100%; }
        .btn-primary:hover { background: #1e40af; }
        .btn-secondary { background: #e5e7eb; color: #333; text-decoration: none; display: inline-block; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="logo">🏠 Aloja</div>
        </div>
    </div>

    <div class="container">
        <div class="payment-card">
            <h1>💳 Realizar Pago</h1>
            <p class="subtitle">Estás a un paso de confirmar tu reserva</p>

            <!-- Resumen de la Reserva -->
            <div class="reservation-summary">
                <h3 style="margin-bottom: 20px; color: #333;">📋 Resumen de Reserva</h3>
                
                <div class="summary-row">
                    <span>Hospedaje:</span>
                    <span><strong>{{ $reserva->hospedaje->titulo }}</strong></span>
                </div>
                
                <div class="summary-row">
                    <span>Ubicación:</span>
                    <span>{{ $reserva->hospedaje->ubicacion }}</span>
                </div>
                
                <div class="summary-row">
                    <span>fecha_inicio:</span>
                    <span>{{ $reserva->fecha_inicio->format('d/m/Y') }}</span>
                </div>
                
                <div class="summary-row">
                    <span>fecha_fin:</span>
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
                
                <div class="summary-row" style="background: #1e3a8a; color: white; margin: 15px -25px -25px -25px; padding: 20px 25px; border-radius: 0 0 8px 8px;">
                    <span style="font-size: 18px;">Total a Pagar:</span>
                    <span style="font-size: 24px;">S/. {{ number_format($reserva->total, 2) }}</span>
                </div>
            </div>

            <!-- Métodos de Pago -->
            <form action="{{ route('pagos.store') }}" method="POST">
                @csrf
                <input type="hidden" name="reserva_id" value="{{ $reserva->id_reserva }}">

                <div class="payment-methods">
                    <h3 style="margin-bottom: 10px; color: #333;">Selecciona tu método de pago</h3>
                    <p style="color: #666; font-size: 14px; margin-bottom: 20px;">Esta es una simulación, no se procesará ningún pago real</p>

                    @if(session('error'))
                        <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 5px; margin-bottom: 15px;">
                            ❌ {{ session('error') }}
                        </div>
                    @endif

                    <div class="method-grid">
                        <div class="method-option">
                            <input type="radio" name="metodo_pago" id="yape" value="yape" required>
                            <label for="yape" class="method-label">
                                <div class="method-icon">📱</div>
                                <div class="method-name">Yape</div>
                            </label>
                        </div>

                        <div class="method-option">
                            <input type="radio" name="metodo_pago" id="plin" value="plin">
                            <label for="plin" class="method-label">
                                <div class="method-icon">💜</div>
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
                                <div class="method-icon">🌐</div>
                                <div class="method-name">PayPal</div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="security-note">
                    <strong>🔒 Pago Seguro Simulado</strong><br>
                    Este es un entorno de prueba. No se procesará ningún cargo real a tu método de pago.
                </div>

                <button type="submit" class="btn btn-primary">
                    Confirmar Pago
                </button>

                <a href="{{ route('reservas.mis-reservas') }}" class="btn btn-secondary" style="width: 100%; margin-top: 15px;">
                    Cancelar y Volver
                </a>
            </form>
        </div>
    </div>

    <div style="height: 50px;"></div>
</body>
</html>