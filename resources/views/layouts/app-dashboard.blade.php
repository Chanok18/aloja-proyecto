<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Aloja Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #1e3a8a;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 24px;
        }
        .sidebar nav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar nav a:hover,
        .sidebar nav a.active {
            background: rgba(255, 255, 255, 0.1);
        }
        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 20px;
        }
        .header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header h1 {
            font-size: 28px;
            color: #333;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-info span {
            color: #666;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn-primary {
            background: #1e3a8a;
            color: white;
        }
        .btn-primary:hover {
            background: #1e40af;
        }
        .btn-danger {
            background: #dc2626;
            color: white;
        }
        .btn-danger:hover {
            background: #b91c1c;
        }
        .content-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            font-size: 14px;
            margin-bottom: 10px;
            opacity: 0.9;
        }
        .stat-card p {
            font-size: 32px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th {
            background: #f3f4f6;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #374151;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        table tr:hover {
            background: #f9fafb;
        }
        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        .logout-btn {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Aloja</h2>
            <p style="margin-bottom: 20px; opacity: 0.8; font-size: 14px;">
                @yield('role-name')
            </p>
            
            <nav>
                @yield('sidebar-menu')
            </nav>

            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="width: 100%;">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>@yield('page-title')</h1>
                <div class="user-info">
                    <span>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span>
                    <span class="badge badge-success">{{ ucfirst(Auth::user()->rol) }}</span>
                </div>
            </div>

            <!-- Content -->
            <div class="content-box">
                @yield('content')
            </div>
        </main>
    </div>
    </div>

    <!-- CHATBOT FLOTANTE -->
    <div id="chatbot-container">
        <!-- Botón Flotante -->
        <button id="chatbot-toggle" onclick="toggleChatbot()" style="
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.4);
            cursor: pointer;
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            transition: all 0.3s;
        " onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            💬
        </button>

        <!-- Modal del Chat -->
        <div id="chatbot-modal" style="
            display: none;
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 380px;
            height: 500px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            z-index: 9999;
            flex-direction: column;
            overflow: hidden;
        ">
            <!-- Header -->
            <div style="
                background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
                color: white;
                padding: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            ">
                <div>
                    <h3 style="margin: 0; font-size: 18px;">🤖 Asistente Aloja</h3>
                    <small style="opacity: 0.9; font-size: 12px;">Con IA - Groq</small>
                </div>
                <button onclick="toggleChatbot()" style="
                    background: rgba(255,255,255,0.2);
                    border: none;
                    color: white;
                    width: 30px;
                    height: 30px;
                    border-radius: 50%;
                    cursor: pointer;
                    font-size: 18px;
                ">✕</button>
            </div>

            <!-- Mensajes -->
            <div id="chatbot-messages" style="
                flex: 1;
                overflow-y: auto;
                padding: 20px;
                background: #f9fafb;
            ">
                <div class="bot-message" style="
                    background: white;
                    padding: 12px 15px;
                    border-radius: 12px;
                    margin-bottom: 15px;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
                    animation: fadeIn 0.3s;
                ">
                    <strong style="color: #1e3a8a; font-size: 13px;">🤖 Asistente</strong>
                    <p style="margin: 5px 0 0 0; color: #333; line-height: 1.5; font-size: 14px;">
                        ¡Hola! Soy el asistente virtual de Aloja. ¿En qué puedo ayudarte hoy? 😊
                    </p>
                </div>
            </div>

            <!-- Input -->
            <div style="
                padding: 15px;
                background: white;
                border-top: 1px solid #e5e7eb;
            ">
                <form id="chatbot-form" style="display: flex; gap: 10px;">
                    <input 
                        type="text" 
                        id="chatbot-input" 
                        placeholder="Escribe tu pregunta..."
                        required
                        style="
                            flex: 1;
                            padding: 12px;
                            border: 1px solid #d1d5db;
                            border-radius: 25px;
                            font-size: 14px;
                            outline: none;
                        "
                    >
                    <button type="submit" style="
                        background: #1e3a8a;
                        color: white;
                        border: none;
                        width: 45px;
                        height: 45px;
                        border-radius: 50%;
                        cursor: pointer;
                        font-size: 18px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    " id="send-btn">
                        ➤
                    </button>
                </form>
                <small style="color: #999; font-size: 11px; display: block; margin-top: 8px; text-align: center;">
                    Powered by Groq AI
                </small>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .user-message {
            background: #1e3a8a;
            color: white;
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 15px;
            margin-left: 40px;
            text-align: right;
            animation: fadeIn 0.3s;
        }
        
        .bot-message {
            animation: fadeIn 0.3s;
        }
        
        #chatbot-messages::-webkit-scrollbar {
            width: 6px;
        }
        
        #chatbot-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        #chatbot-messages::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .typing-indicator {
            display: flex;
            gap: 5px;
            padding: 10px;
        }
        
        .typing-indicator span {
            width: 8px;
            height: 8px;
            background: #1e3a8a;
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
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-10px); }
        }
    </style>

    <script>
        function toggleChatbot() {
            const modal = document.getElementById('chatbot-modal');
            if (modal.style.display === 'none' || modal.style.display === '') {
                modal.style.display = 'flex';
            } else {
                modal.style.display = 'none';
            }
        }

        document.getElementById('chatbot-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const input = document.getElementById('chatbot-input');
            const mensaje = input.value.trim();
            
            if (!mensaje) return;
            
            const messagesContainer = document.getElementById('chatbot-messages');
            
            // Mostrar mensaje del usuario
            const userMessageDiv = document.createElement('div');
            userMessageDiv.className = 'user-message';
            userMessageDiv.innerHTML = `<p style="margin: 0; font-size: 14px;">${mensaje}</p>`;
            messagesContainer.appendChild(userMessageDiv);
            
            // Limpiar input
            input.value = '';
            
            // Scroll al final
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            // Mostrar indicador de escritura
            const typingDiv = document.createElement('div');
            typingDiv.id = 'typing-indicator';
            typingDiv.className = 'bot-message';
            typingDiv.innerHTML = `
                <strong style="color: #1e3a8a; font-size: 13px;">🤖 Asistente</strong>
                <div class="typing-indicator">
                    <span></span><span></span><span></span>
                </div>
            `;
            messagesContainer.appendChild(typingDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            // Deshabilitar botón
            const sendBtn = document.getElementById('send-btn');
            sendBtn.disabled = true;
            sendBtn.style.opacity = '0.5';
            
            try {
                // Enviar a la API
                const response = await fetch('{{ route('chatbot.mensaje') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ mensaje: mensaje })
                });
                
                const data = await response.json();
                
                // Eliminar indicador de escritura
                typingDiv.remove();
                
                // Mostrar respuesta del bot
                const botMessageDiv = document.createElement('div');
                botMessageDiv.className = 'bot-message';
                botMessageDiv.style.background = 'white';
                botMessageDiv.style.padding = '12px 15px';
                botMessageDiv.style.borderRadius = '12px';
                botMessageDiv.style.marginBottom = '15px';
                botMessageDiv.style.boxShadow = '0 2px 5px rgba(0,0,0,0.05)';
                botMessageDiv.innerHTML = `
                    <strong style="color: #1e3a8a; font-size: 13px;">🤖 Asistente</strong>
                    <p style="margin: 5px 0 0 0; color: #333; line-height: 1.5; font-size: 14px;">${data.respuesta}</p>
                `;
                messagesContainer.appendChild(botMessageDiv);
                
            } catch (error) {
                // Eliminar indicador de escritura
                typingDiv.remove();
                
                // Mostrar error
                const errorDiv = document.createElement('div');
                errorDiv.className = 'bot-message';
                errorDiv.style.background = '#fee2e2';
                errorDiv.style.padding = '12px 15px';
                errorDiv.style.borderRadius = '12px';
                errorDiv.style.marginBottom = '15px';
                errorDiv.innerHTML = `
                    <strong style="color: #dc2626; font-size: 13px;">❌ Error</strong>
                    <p style="margin: 5px 0 0 0; color: #991b1b; font-size: 14px;">No pude conectar con el servidor. Intenta de nuevo.</p>
                `;
                messagesContainer.appendChild(errorDiv);
            }
            
            // Rehabilitar botón
            sendBtn.disabled = false;
            sendBtn.style.opacity = '1';
            
            // Scroll al final
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        });
    </script>
</body>
</html>
</body>
</html>