<x-guest-layout>
    <div class="auth-logo">
        <h1>Aloja<span class="pe">.pe</span></h1>
        <p>Inicia sesión en tu cuenta</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Correo -->
        <div class="form-group">
            <label for="correo" class="form-label">Correo electrónico</label>
            <div class="input-icon">
                <span>📧</span>
                <input 
                    id="correo" 
                    class="form-input" 
                    type="email" 
                    name="correo" 
                    value="{{ old('correo') }}" 
                    placeholder="tu@email.com"
                    required 
                    autofocus 
                    autocomplete="username"
                />
            </div>
            @error('correo')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Contraseña -->
        <div class="form-group">
            <label for="contraseña" class="form-label">Contraseña</label>
            <div class="input-icon">
                <span>🔒</span>
                <input 
                    id="contraseña" 
                    class="form-input" 
                    type="password" 
                    name="contraseña"
                    placeholder="••••••••"
                    required 
                    autocomplete="current-password"
                />
            </div>
            @error('contraseña')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="checkbox-group">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Recordarme</label>
        </div>

        <!-- Botón de Login -->
        <button type="submit" class="btn-primary">
            Iniciar Sesión
        </button>

        <!-- ¿Olvidaste tu contraseña? -->
        @if (Route::has('password.request'))
            <div class="forgot-password">
                <a href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
        @endif
    </form>

    <!-- Link a Register -->
    <div class="link-text">
        ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a>
    </div>
</x-guest-layout>