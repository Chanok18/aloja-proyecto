<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    <footer class="bg-dark text-light mt-5 pt-4 pb-4">
        <div class="container">
            <div class="row">

                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold">Aloja.pe</h5>
                    <p>Tu estadía, a un clic de distancia. Hospedajes seguros y confiables en todo el Perú.</p>
                </div>

                <div class="col-md-2 mb-3">
                    <h6 class="fw-bold">Enlaces</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Inicio</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Hospedajes</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Ayuda</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold">Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Términos y condiciones</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Política de privacidad</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Mapa del sitio</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold">Contacto</h6>
                    <p class="m-0">📧 soporte@aloja.pe</p>
                    <p class="m-0">📍 Lima, Perú</p>
                </div>

            </div>

            <hr class="border-light">

            <div class="text-center">
                © 2025 Aloja.pe — Todos los derechos reservados
            </div>
        </div>
    </footer>

    </body>
</html>
