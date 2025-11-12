<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Hospedaje - Aloja</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        
        .header { background: #1e3a8a; color: white; padding: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .container { max-width: 1000px; margin: 0 auto; padding: 0 20px; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 28px; font-weight: bold; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; }
        
        .page-header { background: white; padding: 30px; border-radius: 8px; margin: 30px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .page-header h1 { color: #1e3a8a; margin-bottom: 10px; }
        .breadcrumb { color: #666; font-size: 14px; }
        
        .form-card { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px; }
        
        .form-section { margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #e5e7eb; }
        .form-section:last-child { border-bottom: none; }
        .form-section h2 { color: #333; margin-bottom: 20px; font-size: 20px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 5px; font-size: 16px; }
        .form-group textarea { min-height: 120px; resize: vertical; }
        .form-group small { color: #666; font-size: 14px; display: block; margin-top: 5px; }
        
        .form-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        
        .checkbox-group { display: flex; flex-direction: column; gap: 15px; }
        .checkbox-item { display: flex; align-items: center; padding: 15px; background: #f9fafb; border-radius: 8px; border: 2px solid #e5e7eb; cursor: pointer; transition: all 0.3s; }
        .checkbox-item:hover { background: #f3f4f6; border-color: #1e3a8a; }
        .checkbox-item input[type="checkbox"] { width: 24px; height: 24px; margin-right: 12px; cursor: pointer; }
        .checkbox-item label { font-weight: 600; color: #333; cursor: pointer; flex: 1; }
        
        .btn { padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 16px; }
        .btn-primary { background: #1e3a8a; color: white; }
        .btn-primary:hover { background: #1e40af; }
        .btn-secondary { background: #6b7280; color: white; }
        .btn-secondary:hover { background: #4b5563; }
        
        .form-actions { display: flex; gap: 15px; justify-content: flex-end; margin-top: 30px; }
        
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        
        .error-text { color: #ef4444; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">🏠 Aloja</div>
                <div class="nav-links">
                    <a href="{{ route('home') }}">Inicio</a>
                    <a href="{{ route('anfitrion.dashboard') }}">Dashboard</a>
                    <a href="{{ route('anfitrion.hospedajes.index') }}">Mis Hospedajes</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>➕ Publicar Nuevo Hospedaje</h1>
            <div class="breadcrumb">Dashboard / Mis Hospedajes / Publicar Nuevo</div>
        </div>

        <!-- Formulario -->
        <div class="form-card">
            <form action="{{ route('anfitrion.hospedajes.store') }}" method="POST">
                @csrf

                <!-- Información Básica -->
                <div class="form-section">
                    <h2>📝 Información Básica</h2>
                    
                    <div class="form-group">
                        <label for="titulo">Título del Hospedaje *</label>
                        <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" 
                               placeholder="Ej: Departamento Moderno en Miraflores" required>
                        <small>Un título atractivo ayuda a que tu hospedaje destaque</small>
                        @error('titulo')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción *</label>
                        <textarea id="descripcion" name="descripcion" required 
                                  placeholder="Describe tu hospedaje: qué lo hace especial, qué incluye, reglas de la casa, etc.">{{ old('descripcion') }}</textarea>
                        <small>Una buena descripción aumenta las reservas</small>
                        @error('descripcion')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="ubicacion">Ubicación *</label>
                        <input type="text" id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" 
                               placeholder="Ej: Miraflores, Lima" required>
                        <small>Distrito y ciudad</small>
                        @error('ubicacion')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Detalles del Hospedaje -->
                <div class="form-section">
                    <h2>🏠 Detalles del Hospedaje</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="precio">Precio por Noche (S/.) *</label>
                            <input type="number" id="precio" name="precio" value="{{ old('precio') }}" 
                                   min="0" step="0.01" placeholder="100.00" required>
                            @error('precio')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="capacidad">Capacidad (personas) *</label>
                            <input type="number" id="capacidad" name="capacidad" value="{{ old('capacidad', 1) }}" 
                                   min="1" placeholder="2" required>
                            @error('capacidad')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Amenidades -->
                <div class="form-section">
                    <h2>✨ Amenidades</h2>
                    <p style="color: #666; margin-bottom: 20px;">Selecciona las amenidades que ofrece tu hospedaje</p>
                    
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="wifi" name="wifi" value="1" {{ old('wifi') ? 'checked' : '' }}>
                            <label for="wifi">📶 WiFi</label>
                        </div>

                        <div class="checkbox-item">
                            <input type="checkbox" id="cocina" name="cocina" value="1" {{ old('cocina') ? 'checked' : '' }}>
                            <label for="cocina">🍳 Cocina equipada</label>
                        </div>

                        <div class="checkbox-item">
                            <input type="checkbox" id="estacionamiento" name="estacionamiento" value="1" {{ old('estacionamiento') ? 'checked' : '' }}>
                            <label for="estacionamiento">🚗 Estacionamiento</label>
                        </div>
                    </div>
                </div>

                <!-- Disponibilidad -->
                <div class="form-section">
                    <h2>📅 Disponibilidad</h2>
                    
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="disponible" name="disponible" value="1" checked>
                            <label for="disponible">✅ Marcar como disponible para reservas</label>
                        </div>
                    </div>
                    <small style="color: #666;">Si no marcas esta opción, el hospedaje no será visible para los viajeros</small>
                </div>

                <!-- Botones de Acción -->
                <div class="form-actions">
                    <a href="{{ route('anfitrion.hospedajes.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Publicar Hospedaje
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div style="height: 50px;"></div>
</body>
</html>