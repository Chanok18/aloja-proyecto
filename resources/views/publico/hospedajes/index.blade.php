<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Aloja.pe - Encuentra tu hospedaje perfecto en Perú</title>
    <link rel="stylesheet" href="{{ asset('css/aloja-design.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <style>
        html { scroll-behavior: smooth; }
        .user-message {
            background: var(--color-azul-principal);
            color: white;
            padding: 15px 18px;
            border-radius: 15px;
            margin-bottom: 15px;
            margin-left: 40px;
            text-align: right;
            box-shadow: 0 2px 8px rgba(43,79,155,0.3);
        }
        .typing-indicator {
            display:flex;
            gap:6px;
            padding:12px;
            justify-content:center;
        }
        .typing-indicator span {
            width:10px;
            height:10px;
            background:var(--color-azul-principal);
            border-radius:50%;
            animation: typing 1.4s infinite;
        }
        .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
        .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

        @keyframes typing {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.6; }
            30% { transform: translateY(-12px); opacity: 1; }
        }
        
        @media (max-width: 992px) {
            footer > div > div:first-child { grid-template-columns: repeat(2, 1fr) !important; }
        }
        @media (max-width: 576px) {
            footer > div > div:first-child { grid-template-columns: 1fr !important; }
        }
    </style>
</head>
<body>
    <!-- HEADER / NAVBAR -->
    <header class="aloja-header">
        <nav class="aloja-navbar">
            <a href="{{ route('home') }}" class="aloja-logo">
                Aloja.pe
                <span class="aloja-logo-subtitle">Tu estadía, a un clic de distancia</span>
            </a>

            <div class="aloja-nav-links">
                <a href="{{ route('home') }}">Inicio</a>
                <a href="#hospedajes-destacados">Hospedajes</a>
                <a href="#footer-contacto">Ayuda</a>
            </div>

            <div class="aloja-nav-buttons">
                @auth
                    @if(auth()->user()->esAnfitrion())
                        <a href="{{ route('anfitrion.dashboard') }}" class="btn-aloja btn-aloja-secondary">
                            🏠 Convertirse en Anfitrión
                        </a>
                    @else
                        <a href="#" class="btn-aloja btn-aloja-secondary">🏠 Convertirse en Anfitrión</a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="btn-aloja btn-aloja-primary">👤 Mi Panel</a>
                @else
                    <a href="#" class="btn-aloja btn-aloja-secondary">🏠 Convertirse en Anfitrión</a>
                    <a href="{{ route('login') }}" class="btn-aloja btn-aloja-secondary">🔓 Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn-aloja btn-aloja-primary">⭐ Registrarse</a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- HERO SECTION -->
    <section class="aloja-hero">
        <div class="aloja-hero-content">
            <h1>Encuentra tu estadía perfecta</h1>
            <p class="aloja-hero-subtitle">Hospedajes seguros y confiables en todo el Perú</p>
            <p class="aloja-hero-description">Desde las montañas de Cusco hasta las costas de Lima</p>

            <!-- BUSCADOR -->
            <div class="aloja-search-box">
                <form action="{{ route('home') }}" method="GET">
                    <div class="aloja-search-grid">
                        <div class="aloja-search-field">
                            <label class="aloja-search-label">📍 Ubicación</label>
                            <input type="text" name="ubicacion" class="aloja-search-input" placeholder="¿A dónde vas?" value="{{ request('ubicacion') }}">
                        </div>

                        <div class="aloja-search-field">
                            <label class="aloja-search-label">📅 Check-in</label>
                            <input type="date" name="check_in" class="aloja-search-input" value="{{ request('check_in') }}">
                        </div>

                        <div class="aloja-search-field">
                            <label class="aloja-search-label">📅 Check-out</label>
                            <input type="date" name="check_out" class="aloja-search-input" value="{{ request('check_out') }}">
                        </div>

                        <div class="aloja-search-field">
                            <label class="aloja-search-label">👥 Huéspedes</label>
                            <select name="capacidad" class="aloja-search-select">
                                <option value="">Seleccionar</option>
                                <option value="1" {{ request('capacidad') == '1' ? 'selected' : '' }}>1 huésped</option>
                                <option value="2" {{ request('capacidad') == '2' ? 'selected' : '' }}>2 huéspedes</option>
                                <option value="3" {{ request('capacidad') == '3' ? 'selected' : '' }}>3 huéspedes</option>
                                <option value="4" {{ request('capacidad') == '4' ? 'selected' : '' }}>4 huéspedes</option>
                                <option value="5" {{ request('capacidad') == '5' ? 'selected' : '' }}>5+ huéspedes</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="aloja-search-button">🔍 Buscar</button>
                </form>
            </div>
        </div>
    </section>

    <!-- HOSPEDAJES DESTACADOS -->
    <section class="aloja-section" id="hospedajes-destacados">
        <div class="aloja-section-header">
            <h2 class="aloja-section-title">Hospedajes Destacados</h2>
            <p class="aloja-section-subtitle">
                Descubre los alojamientos mejor valorados por nuestros huéspedes en destinos únicos del Perú
            </p>
        </div>

        @if($hospedajes->count() > 0)
            <div class="aloja-hospedajes-grid">
                @foreach($hospedajes as $hospedaje)
                    <a href="{{ route('hospedajes.publico.show', $hospedaje->id_hospedaje) }}" style="text-decoration: none; color: inherit;">
                        <div class="aloja-hospedaje-card">
                            <div class="aloja-card-image-container">
                                @if($hospedaje->fotoPrincipal())
                                    <img src="{{ $hospedaje->urlFotoPrincipal() }}" alt="{{ $hospedaje->titulo }}" class="aloja-card-image">
                                @else
                                    <div class="aloja-card-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display:flex;align-items:center;justify-content:center;font-size:80px;">🏠</div>
                                @endif

                                @if($hospedaje->disponible)
                                    <span class="aloja-card-badge">✓ Verificado</span>
                                @endif
                                <div class="aloja-card-favorite">❤️</div>
                            </div>

                            <div class="aloja-card-content">
                                <p class="aloja-card-location">📍 {{ $hospedaje->ubicacion }}</p>
                                <h3 class="aloja-card-title">{{ $hospedaje->titulo }}</h3>

                                <div class="aloja-card-footer">
                                    <div>
                                        <span class="aloja-card-price">S/. {{ number_format($hospedaje->precio, 0) }}</span>
                                        <span class="aloja-card-price-label">/ noche</span>
                                    </div>
                                    <div class="aloja-card-rating">
                                        <span style="color: #FFC107;">⭐</span>
                                        <span>{{ number_format($hospedaje->promedioCalificacion(), 1) }}</span>
                                        <span style="color: #999;">({{ $hospedaje->totalResenas() }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($hospedajes->hasPages())
                <div class="aloja-ver-mas" style="text-align:center; margin-top:40px;">
                    <a href="{{ $hospedajes->nextPageUrl() }}" class="btn-aloja btn-aloja-primary" style="padding:14px 40px;">Ver más</a>
                </div>
            @endif
        @else
            <div style="text-align: center; padding: 80px 20px;">
                <div style="font-size: 100px; margin-bottom: 20px;">🏠</div>
                <h3 style="color: #666; margin-bottom: 10px;">No se encontraron hospedajes</h3>
                <p style="color: #999;">Intenta ajustar los filtros de búsqueda</p>
            </div>
        @endif
    </section>

    <!-- ¿POR QUÉ ELEGIR ALOJA? -->
    <section class="aloja-section" style="background: white;">
        <div class="aloja-section-header">
            <h2 class="aloja-section-title">¿Por qué elegir Aloja?</h2>
            <p class="aloja-section-subtitle">Somos la plataforma líder en hospedajes de confianza en Perú y Latinoamérica</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="text-align: center; padding: 30px;">
                <div style="width: 80px; height: 80px; background: var(--color-azul-principal); border-radius: 50%; display:flex; align-items:center; justify-content:center; font-size:36px; margin: 0 auto 20px; color: white;">🛡️</div>
                <h3 style="font-size:22px; font-weight:700; margin-bottom:12px; color:#1A1A1A;">Seguridad</h3>
                <p style="font-size:15px; color:#666; line-height:1.6;">Todos nuestros anfitriones son verificados y los hospedajes cumplen estrictos estándares de seguridad y limpieza.</p>
            </div>

            <div style="text-align: center; padding: 30px;">
                <div style="width: 80px; height: 80px; background: var(--color-azul-principal); border-radius: 50%; display:flex; align-items:center; justify-content:center; font-size:36px; margin: 0 auto 20px; color: white;">🏘️</div>
                <h3 style="font-size:22px; font-weight:700; margin-bottom:12px; color:#1A1A1A;">Variedad</h3>
                <p style="font-size:15px; color:#666; line-height:1.6;">Desde departamentos modernos en Lima hasta cabañas tradicionales en Cusco. Encuentra el lugar perfecto para ti.</p>
            </div>

            <div style="text-align: center; padding: 30px;">
                <div style="width: 80px; height: 80px; background: var(--color-azul-principal); border-radius: 50%; display:flex; align-items:center; justify-content:center; font-size:36px; margin: 0 auto 20px; color: white;">⚡</div>
                <h3 style="font-size:22px; font-weight:700; margin-bottom:12px; color:#1A1A1A;">Reserva Fácil</h3>
                <p style="font-size:15px; color:#666; line-height:1.6;">Proceso de reserva simple y seguro. Confirmación instantánea y soporte 24/7 en español para tu tranquilidad.</p>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer style="background: #0B1D3D; color: white; padding: 60px 20px 30px; margin-top: 40px;" id="footer-contacto">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px; margin-bottom: 50px;">
                <!-- Empresa -->
                <div>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: white;">Empresa</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 12px;"><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Nosotros</a></li>
                        <li style="margin-bottom: 12px;"><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Inversionistas</a></li>
                        <li><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Blog</a></li>
                    </ul>
                </div>

                <!-- Comunidad -->
                <div>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: white;">Comunidad</h4>
                    <ul style="list-style:none; padding:0; margin:0;">
                        <li style="margin-bottom:12px;"><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Centro de recursos</a></li>
                        <li style="margin-bottom:12px;"><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Foro de la comunidad</a></li>
                        <li style="margin-bottom:12px;"><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Referir anfitriones</a></li>
                        <li><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Eventos</a></li>
                    </ul>
                </div>

                <!-- Anfitriones -->
                <div>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: white;">Anfitriones</h4>
                    <ul style="list-style:none; padding:0; margin:0;">
                        <li style="margin-bottom:12px;"><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Alojar mi espacio</a></li>
                        <li style="margin-bottom:12px;"><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Foro de anfitriones</a></li>
                        <li style="margin-bottom:12px;"><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Hospedaje responsable</a></li>
                        <li><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Conectar con un embajador</a></li>
                    </ul>
                </div>

                <!-- Soporte -->
                <div>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: white;">Soporte</h4>
                    <ul style="list-style:none; padding:0; margin:0;">
                        <li style="margin-bottom:12px;"><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Centro de ayuda</a></li>
                        <li style="margin-bottom:12px;"><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Opciones de cancelación</a></li>
                        <li style="margin-bottom:12px;"><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Reportar problema</a></li>
                        <li><a href="#" style="color:#B0B8C8; text-decoration:none; font-size:14px;">Contactar soporte</a></li>
                    </ul>
                </div>
            </div>

            <!-- Contacto -->
            <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 30px; margin-bottom: 30px;">
                <h4 style="font-size:16px; font-weight:700; margin-bottom:20px; color:white;">Contacto</h4>
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <a href="tel:+5112345678" style="color:#B0B8C8; text-decoration:none; font-size:14px; display:flex; align-items:center; gap:8px;">📞 +51 1 234 5678</a>
                    <a href="mailto:contacto@aloja.pe" style="color:#B0B8C8; text-decoration:none; font-size:14px; display:flex; align-items:center; gap:8px;">✉️ contacto@aloja.pe</a>
                    <p style="color:#B0B8C8; font-size:14px; margin:0; display:flex; align-items:center; gap:8px;">💬 Chat en vivo disponible 24/7</p>
                </div>
            </div>

            <!-- Redes y legal -->
            <div style="border-top:1px solid rgba(255,255,255,0.1); padding-top:30px; display:flex; justify-content:space-between; align-items:center;">
                <div style="display:flex; gap:15px; align-items:center;">
                    <a href="#" style="color:#B0B8C8; text-decoration:none; font-size:12px;">Términos de servicio</a>
                    <span style="color:#B0B8C8;">•</span>
                    <a href="#" style="color:#B0B8C8; text-decoration:none; font-size:12px;">Política de privacidad</a>
                </div>

                <div style="display:flex; gap:20px; align-items:center;">
                    <p style="color:#B0B8C8; font-size:12px; margin:0;">Síguenos</p>
                    <a href="#" style="color:#B0B8C8; font-size:20px; text-decoration:none;"><i class="bi bi-facebook"></i></a>
                    <a href="#" style="color:#B0B8C8; font-size:20px; text-decoration:none;"><i class="bi bi-youtube"></i></a>
                    <a href="#" style="color:#B0B8C8; font-size:20px; text-decoration:none;"><i class="bi bi-instagram"></i></a>
                </div>
            </div>

            <div style="text-align:center; margin-top:30px;">
                <p style="color:#B0B8C8; font-size:12px; margin:0;">© 2025 Aloja · Todos los derechos reservados</p>
            </div>
        </div>
    </footer>

    <!-- Chatbot Alojita -->
    <div id="chatbot-container">
        <button id="chatbot-toggle" onclick="toggleChatbot()" style="position:fixed;bottom:30px;right:30px;width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#2B4F9B 0%,#3b82f6 100%);border:none;box-shadow:0 6px 20px rgba(43,79,155,0.5);cursor:pointer;z-index:9998;display:flex;align-items:center;justify-content:center;font-size:38px;transition:all 0.3s;" onmouseover="this.style.transform='scale(1.15)';this.style.boxShadow='0 8px 25px rgba(43,79,155,0.6)'" onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 6px 20px rgba(43,79,155,0.5)'">🤖</button>
        
        <div id="chatbot-modal" style="display:none;position:fixed;bottom:120px;right:30px;width:400px;height:550px;background:white;border-radius:20px;box-shadow:0 12px 50px rgba(0,0,0,0.25);z-index:9999;flex-direction:column;overflow:hidden;">
            <div style="background:linear-gradient(135deg,#2B4F9B 0%,#3b82f6 100%);color:white;padding:25px;display:flex;justify-content:space-between;align-items:center;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="font-size:32px;">🤖</div>
                    <div>
                        <h3 style="margin:0;font-size:19px;font-weight:700;">Alojita</h3>
                        <small style="opacity:0.9;font-size:12px;">Asistente de Aloja</small>
                    </div>
                </div>
                <button onclick="toggleChatbot()" style="background:rgba(255,255,255,0.2);border:none;color:white;width:35px;height:35px;border-radius:50%;cursor:pointer;font-size:20px;transition:all 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">✕</button>
            </div>
            
            <div id="chatbot-messages" style="flex:1;overflow-y:auto;padding:25px;background:#f9fafb;">
                <div class="bot-message" style="background:white;padding:15px 18px;border-radius:15px;margin-bottom:15px;box-shadow:0 2px 8px rgba(0,0,0,0.08);border-left:4px solid #2B4F9B;">
                    <strong style="color:#2B4F9B;font-size:14px;display:flex;align-items:center;gap:6px;margin-bottom:6px;"><span style="font-size:18px;">🤖</span> Alojita</strong>
                    <p style="margin:0;color:#333;line-height:1.6;font-size:14px;">¡Hola! 👋 Soy "Alojita" tu asistente virtual. Estoy aquí para ayudarte con cualquier pregunta sobre hospedajes, reservas o nuestros servicios. ¿En qué puedo ayudarte hoy? 😊</p>
                </div>
            </div>
            
            <div style="padding:20px;background:white;border-top:1px solid #e5e7eb;">
                <form id="chatbot-form" style="display:flex;gap:12px;">
                    <input type="text" id="chatbot-input" placeholder="Escribe tu pregunta..." required style="flex:1;padding:14px 18px;border:2px solid #d1d5db;border-radius:25px;font-size:14px;outline:none;transition:all 0.3s;" onfocus="this.style.borderColor='#2B4F9B'" onblur="this.style.borderColor='#d1d5db'">
                    <button type="submit" style="background:#2B4F9B;color:white;border:none;width:50px;height:50px;border-radius:50%;cursor:pointer;font-size:20px;transition:all 0.3s;box-shadow:0 2px 8px rgba(43,79,155,0.3);" id="send-btn" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">➤</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function toggleChatbot() {
        const modal = document.getElementById('chatbot-modal');
        modal.style.display = (modal.style.display === 'flex' || modal.style.display === 'block') ? 'none' : 'flex';
    }
    
    document.getElementById('chatbot-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const input = document.getElementById('chatbot-input');
        const mensaje = input.value.trim();
        if (!mensaje) return;
        
        const messagesContainer = document.getElementById('chatbot-messages');
        
        // Mensaje del usuario
        const userMessageDiv = document.createElement('div');
        userMessageDiv.className = 'user-message';
        userMessageDiv.innerHTML = '<p style="margin:0;font-size:14px;">' + mensaje + '</p>';
        messagesContainer.appendChild(userMessageDiv);
        input.value = '';
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        // Indicador de escritura
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-indicator';
        typingDiv.className = 'bot-message';
        typingDiv.style.cssText = 'background:white;padding:15px 18px;border-radius:15px;margin-bottom:15px;box-shadow:0 2px 8px rgba(0,0,0,0.08);border-left:4px solid #2B4F9B;';
        typingDiv.innerHTML = '<strong style="color:#2B4F9B;font-size:14px;display:flex;align-items:center;gap:6px;margin-bottom:6px;"><span style="font-size:18px;">🤖</span> Alojita</strong><div class="typing-indicator"><span></span><span></span><span></span></div>';
        messagesContainer.appendChild(typingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        const sendBtn = document.getElementById('send-btn');
        sendBtn.disabled = true;
        sendBtn.style.opacity = '0.5';
        
        try {
            const response = await fetch('{{ route("chatbot.mensaje") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ mensaje: mensaje })
            });
            
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            
            const data = await response.json();
            typingDiv.remove();
            
            const botMessageDiv = document.createElement('div');
            botMessageDiv.className = 'bot-message';
            botMessageDiv.style.cssText = 'background:white;padding:15px 18px;border-radius:15px;margin-bottom:15px;box-shadow:0 2px 8px rgba(0,0,0,0.08);border-left:4px solid #2B4F9B;';
            botMessageDiv.innerHTML = '<strong style="color:#2B4F9B;font-size:14px;display:flex;align-items:center;gap:6px;margin-bottom:6px;"><span style="font-size:18px;">🤖</span> Alojita</strong><p style="margin:0;color:#333;line-height:1.6;font-size:14px;">' + data.respuesta + '</p>';
            messagesContainer.appendChild(botMessageDiv);
            
        } catch (error) {
            typingDiv.remove();
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'bot-message';
            errorDiv.style.cssText = 'background:#fee2e2;padding:15px 18px;border-radius:15px;margin-bottom:15px;border-left:4px solid #dc2626;';
            errorDiv.innerHTML = '<strong style="color:#dc2626;font-size:14px;display:flex;align-items:center;gap:6px;margin-bottom:6px;"><span style="font-size:18px;">❌</span> Error</strong><p style="margin:0;color:#991b1b;font-size:14px;">No pude conectar con el servidor. Por favor intenta de nuevo.</p>';
            messagesContainer.appendChild(errorDiv);
        }
        
        sendBtn.disabled = false;
        sendBtn.style.opacity = '1';
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    });
</script>
</body>
</html>