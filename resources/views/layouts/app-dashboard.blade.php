<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Aloja Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #F5F7FA;
            color: #1A1A1A;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* ============================================
           SIDEBAR - DISEÑO FIGMA
        ============================================ */
        .sidebar {
            width: 240px;
            background: #2B4F9B;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-header {
            padding: 30px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .sidebar-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            color: white;
        }

        .sidebar-avatar.admin {
            background: #EF4444;
        }

        .sidebar-avatar.anfitrion {
            background: #10B981;
        }

        .sidebar-avatar.viajero {
            background: #3B82F6;
        }

        .sidebar-user-info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 2px;
            color: white;
        }

        .sidebar-user-info p {
            font-size: 12px;
            opacity: 0.8;
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            margin: 2px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar-nav a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav a.active {
            background: rgba(255, 255, 255, 0.15);
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-logout {
            width: 100%;
            padding: 12px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-logout:hover {
            background: #EF4444;
        }

        /* ============================================
           MAIN CONTENT
        ============================================ */
        .main-content {
            margin-left: 240px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ============================================
           HEADER - DISEÑO FIGMA
        ============================================ */
        .top-header {
            background: white;
            padding: 16px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #E5E7EB;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-back {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6B7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .btn-back:hover {
            color: #2B4F9B;
        }

        .header-logo {
            font-size: 20px;
            font-weight: 700;
            color: #2B4F9B;
        }

        .header-logo span {
            color: #F5C344;
        }

        .header-subtitle {
            font-size: 14px;
            color: #9CA3AF;
            margin-left: 12px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notifications-badge {
            position: relative;
            padding: 8px 16px;
            background: #FEF2F2;
            color: #DC2626;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .notifications-badge::before {
            content: '🔔';
            font-size: 16px;
        }

        .header-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            color: white;
            cursor: pointer;
        }

        /* ============================================
           CONTENT AREA
        ============================================ */
        .content-wrapper {
            flex: 1;
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #1A1A1A;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 15px;
            color: #6B7280;
        }

        .content-box {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* ============================================
           STATS CARDS - DISEÑO FIGMA
        ============================================ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border-left: 4px solid;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .stat-card.blue {
            border-color: #3B82F6;
        }

        .stat-card.purple {
            border-color: #A855F7;
        }

        .stat-card.cyan {
            border-color: #06B6D4;
        }

        .stat-card.green {
            border-color: #10B981;
        }

        .stat-card h3 {
            font-size: 14px;
            font-weight: 600;
            color: #6B7280;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card p {
            font-size: 32px;
            font-weight: 700;
            color: #1A1A1A;
            margin-bottom: 8px;
        }

        .stat-card small {
            font-size: 13px;
            color: #9CA3AF;
            display: block;
            line-height: 1.5;
        }

        /* ============================================
           TABLAS
        ============================================ */
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #F9FAFB;
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #E5E7EB;
        }

        table td {
            padding: 16px;
            border-bottom: 1px solid #F3F4F6;
            font-size: 14px;
            color: #1F2937;
        }

        table tbody tr {
            transition: background 0.2s;
        }

        table tbody tr:hover {
            background: #F9FAFB;
        }

        /* ============================================
           BADGES
        ============================================ */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            gap: 4px;
        }

        .badge-success {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-warning {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge-danger {
            background: #FEE2E2;
            color: #991B1B;
        }

        .badge-info {
            background: #DBEAFE;
            color: #1E40AF;
        }

        /* ============================================
           BOTONES
        ============================================ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #2B4F9B;
            color: white;
        }

        .btn-primary:hover {
            background: #1e3a8a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(43, 79, 155, 0.3);
        }

        .btn-secondary {
            background: #6B7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4B5563;
        }

        /* ============================================
           SECCIÓN HEADER
        ============================================ */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #1A1A1A;
        }

        /* ============================================
           EMPTY STATE
        ============================================ */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #F9FAFB;
            border-radius: 12px;
            margin-top: 20px;
        }

        .empty-state-icon {
            font-size: 80px;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            color: #9CA3AF;
            margin-bottom: 20px;
        }

        /* ============================================
           RESPONSIVE
        ============================================ */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-user">
                    <div class="sidebar-avatar {{ Auth::user()->rol }}">
                        {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                    </div>
                    <div class="sidebar-user-info">
                        <h3>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</h3>
                        <p>{{ ucfirst(Auth::user()->rol) }}</p>
                    </div>
                </div>
            </div>

            <nav class="sidebar-nav">
                @yield('sidebar-menu')
            </nav>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <!-- TOP HEADER -->
            <header class="top-header">
                <div class="header-left">
                    <a href="{{ route('home') }}" class="btn-back">
                        ← Volver al inicio
                    </a>
                    <div>
                        <span class="header-logo">Aloja<span>.pe</span></span>
                        <span class="header-subtitle">@yield('role-name')</span>
                    </div>
                </div>

                <div class="header-right">
                    @php
                        $pendientes = 0;
                        if(Auth::user()->esAdmin()) {
                            $pendientes = \App\Models\Reserva::where('estado', 'pendiente')->count();
                        }
                    @endphp
                    
                    @if($pendientes > 0)
                        <div class="notifications-badge">
                            {{ $pendientes }} pendientes
                        </div>
                    @endif

                    <div class="header-avatar {{ Auth::user()->rol }}">
                        {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- CONTENT WRAPPER -->
            <div class="content-wrapper">
                <div class="page-header">
                    <h1 class="page-title">@yield('page-title')</h1>
                    <p class="page-subtitle">@yield('page-description', 'Resumen general de la plataforma Aloja.pe')</p>
                </div>

                @yield('content')
            </div>
        </main>
    </div>

    <!-- CHATBOT FLOTANTE MEJORADO -->
    <div id="chatbot-container">
        <button id="chatbot-toggle" onclick="toggleChatbot()" style="
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2B4F9B 0%, #3b82f6 100%);
            border: none;
            box-shadow: 0 6px 20px rgba(43, 79, 155, 0.5);
            cursor: pointer;
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            transition: all 0.3s;
        " onmouseover="this.style.transform='scale(1.15)'; this.style.boxShadow='0 8px 25px rgba(43, 79, 155, 0.6)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 6px 20px rgba(43, 79, 155, 0.5)'">
            🤖
        </button>

        <div id="chatbot-modal" style="
            display: none;
            position: fixed;
            bottom: 120px;
            right: 30px;
            width: 400px;
            height: 550px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 12px 50px rgba(0,0,0,0.25);
            z-index: 9999;
            flex-direction: column;
            overflow: hidden;
        ">
            <div style="
                background: linear-gradient(135deg, #2B4F9B 0%, #3b82f6 100%);
                color: white;
                padding: 25px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            ">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="font-size: 32px;">🤖</div>
                    <div>
                        <h3 style="margin: 0; font-size: 19px; font-weight: 700;">Asistente Aloja</h3>
                        <small style="opacity: 0.9; font-size: 12px;">Powered by Groq AI</small>
                    </div>
                </div>
                <button onclick="toggleChatbot()" style="
                    background: rgba(255,255,255,0.2);
                    border: none;
                    color: white;
                    width: 35px;
                    height: 35px;
                    border-radius: 50%;
                    cursor: pointer;
                    font-size: 20px;
                    transition: all 0.3s;
                " onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">✕</button>
            </div>

            <div id="chatbot-messages" style="
                flex: 1;
                overflow-y: auto;
                padding: 25px;
                background: #f9fafb;
            ">
                <div class="bot-message" style="
                    background: white;
                    padding: 15px 18px;
                    border-radius: 15px;
                    margin-bottom: 15px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                    border-left: 4px solid #2B4F9B;
                ">
                    <strong style="color: #2B4F9B; font-size: 14px; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                        <span style="font-size: 18px;">🤖</span> Asistente Aloja
                    </strong>
                    <p style="margin: 0; color: #333; line-height: 1.6; font-size: 14px;">
                        ¡Hola! 👋 Soy tu asistente virtual. Estoy aquí para ayudarte con cualquier pregunta sobre hospedajes, reservas o nuestros servicios. ¿En qué puedo ayudarte hoy? 😊
                    </p>
                </div>
            </div>

            <div style="
                padding: 20px;
                background: white;
                border-top: 1px solid #e5e7eb;
            ">
                <form id="chatbot-form" style="display: flex; gap: 12px;">
                    <input 
                        type="text" 
                        id="chatbot-input" 
                        placeholder="Escribe tu pregunta..."
                        required
                        style="
                            flex: 1;
                            padding: 14px 18px;
                            border: 2px solid #d1d5db;
                            border-radius: 25px;
                            font-size: 14px;
                            outline: none;
                            transition: all 0.3s;
                        "
                        onfocus="this.style.borderColor='#2B4F9B'"
                        onblur="this.style.borderColor='#d1d5db'"
                    >
                    <button type="submit" style="
                        background: #2B4F9B;
                        color: white;
                        border: none;
                        width: 50px;
                        height: 50px;
                        border-radius: 50%;
                        cursor: pointer;
                        font-size: 20px;
                        transition: all 0.3s;
                        box-shadow: 0 2px 8px rgba(43, 79, 155, 0.3);
                    " id="send-btn" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        ➤
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .user-message {
            background: #2B4F9B;
            color: white;
            padding: 15px 18px;
            border-radius: 15px;
            margin-bottom: 15px;
            margin-left: 40px;
            text-align: right;
            box-shadow: 0 2px 8px rgba(43, 79, 155, 0.3);
        }
        
        .typing-indicator {
            display: flex;
            gap: 6px;
            padding: 12px;
            justify-content: center;
        }
        
        .typing-indicator span {
            width: 10px;
            height: 10px;
            background: #2B4F9B;
            border-radius: 50%;
            animation: typing 1.4s infinite;
        }
        
        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes typing {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.6; }
            30% { transform: translateY(-12px); opacity: 1; }
        }
    </style>

    <script>
        function toggleChatbot() {
            const modal = document.getElementById('chatbot-modal');
            modal.style.display = modal.style.display === 'none' ? 'flex' : 'none';
        }

        document.getElementById('chatbot-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const input = document.getElementById('chatbot-input');
            const mensaje = input.value.trim();
            if (!mensaje) return;
            
            const messagesContainer = document.getElementById('chatbot-messages');
            
            const userMessageDiv = document.createElement('div');
            userMessageDiv.className = 'user-message';
            userMessageDiv.innerHTML = `<p style="margin: 0; font-size: 14px;">${mensaje}</p>`;
            messagesContainer.appendChild(userMessageDiv);
            input.value = '';
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            const typingDiv = document.createElement('div');
            typingDiv.id = 'typing-indicator';
            typingDiv.className = 'bot-message';
            typingDiv.style.cssText = 'background: white; padding: 15px 18px; border-radius: 15px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #2B4F9B;';
            typingDiv.innerHTML = `
                <strong style="color: #2B4F9B; font-size: 14px; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                    <span style="font-size: 18px;">🤖</span> Asistente
                </strong>
                <div class="typing-indicator"><span></span><span></span><span></span></div>
            `;
            messagesContainer.appendChild(typingDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            const sendBtn = document.getElementById('send-btn');
            sendBtn.disabled = true;
            sendBtn.style.opacity = '0.5';
            
            try {
                const response = await fetch('{{ route('chatbot.mensaje') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ mensaje: mensaje })
                });
                
                const data = await response.json();
                typingDiv.remove();
                
                const botMessageDiv = document.createElement('div');
                botMessageDiv.className = 'bot-message';
                botMessageDiv.style.cssText = 'background: white; padding: 15px 18px; border-radius: 15px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #2B4F9B;';
                botMessageDiv.innerHTML = `
                    <strong style="color: #2B4F9B; font-size: 14px; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                        <span style="font-size: 18px;">🤖</span> Asistente Aloja
                    </strong>
                    <p style="margin: 0; color: #333; line-height: 1.6; font-size: 14px;">${data.respuesta}</p>
                `;
                messagesContainer.appendChild(botMessageDiv);
                
            } catch (error) {
                typingDiv.remove();
                const errorDiv = document.createElement('div');
                errorDiv.className = 'bot-message';
                errorDiv.style.cssText = 'background: #fee2e2; padding: 15px 18px; border-radius: 15px; margin-bottom: 15px; border-left: 4px solid #dc2626;';
                errorDiv.innerHTML = `
                    <strong style="color: #dc2626; font-size: 14px; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                        <span style="font-size: 18px;">❌</span> Error
                    </strong>
                    <p style="margin: 0; color: #991b1b; font-size: 14px;">No pude conectar con el servidor. Por favor intenta de nuevo.</p>
                `;
                messagesContainer.appendChild(errorDiv);
            }
            
            sendBtn.disabled = false;
            sendBtn.style.opacity = '1';
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        });
    </script>
</body>
</html>