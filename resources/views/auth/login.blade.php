<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

    <!-- Correo -->
    <div>
        <x-input-label for="correo" :value="__('Correo')" />
        <x-text-input id="correo" class="block mt-1 w-full" type="email" name="correo" :value="old('correo')" required autofocus autocomplete="username" />
        <x-input-error :messages="$errors->get('correo')" class="mt-2" />
    </div>

    <!-- Contraseña -->
    <div class="mt-4">
        <x-input-label for="contraseña" :value="__('Contraseña')" />
        <x-text-input id="contraseña" class="block mt-1 w-full"
                        type="password"
                        name="contraseña"
                        required autocomplete="current-password" />
        <x-input-error :messages="$errors->get('contraseña')" class="mt-2" />
    </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
