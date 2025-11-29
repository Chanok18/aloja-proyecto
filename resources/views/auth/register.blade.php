<x-guest-layout>
    <div class="auth-logo">
        <h1>Aloja<span class="pe">.pe</span></h1>
        <p>Crea tu cuenta y empieza a explorar</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombre -->
        <div class="form-group">
            <label for="nombre" class="form-label">Nombre</label>
            <input 
                id="nombre" 
                class="form-input" 
                type="text" 
                name="nombre" 
                value="{{ old('nombre') }}" 
                placeholder="Tu nombre"
                required 
                autofocus 
                autocomplete="nombre"
            />
            @error('nombre')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Apellido -->
        <div class="form-group">
            <label for="apellido" class="form-label">Apellido</label>
            <input 
                id="apellido" 
                class="form-input" 
                type="text" 
                name="apellido" 
                value="{{ old('apellido') }}" 
                placeholder="Tu apellido"
                required 
                autocomplete="apellido"
            />
            @error('apellido')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Correo -->
        <div class="form-group">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input 
                id="correo" 
                class="form-input" 
                type="email" 
                name="correo" 
                value="{{ old('correo') }}" 
                placeholder="tu@email.com"
                required 
                autocomplete="username"
            />
            @error('correo')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Contraseña -->
        <div class="form-group">
            <label for="contraseña" class="form-label">Contraseña</label>
            <input 
                id="contraseña" 
                class="form-input" 
                type="password" 
                name="contraseña"
                placeholder="••••••••"
                required 
                autocomplete="new-password"
            />
            @error('contraseña')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirmar Contraseña -->
        <div class="form-group">
            <label for="contraseña_confirmation" class="form-label">Confirmar Contraseña</label>
            <input 
                id="contraseña_confirmation" 
                class="form-input" 
                type="password" 
                name="contraseña_confirmation"
                placeholder="••••••••"
                required 
                autocomplete="new-password"
            />
            @error('contraseña_confirmation')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Botón de Registro -->
        <button type="submit" class="btn-secondary">
            Registrarse
        </button>
    </form>

    <!-- Link a Login -->
    <div class="link-text">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
    </div>
</x-guest-layout>