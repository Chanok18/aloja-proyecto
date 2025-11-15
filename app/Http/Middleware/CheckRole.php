<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
     #Middleware que controla el acceso según el rol del usuario y uso de rutas
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        #Verificar si el usuario esta registrado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        #Obtener el rol del usuario actual
        $userRole = Auth::user()->rol;

        #Verificar si el rol del usuario está en los roles permitidos
        if (!in_array($userRole, $roles)) {
            # Si no tiene permiso, redirigir a su dashboard correspondiente
            return match($userRole) {
                'admin' => redirect()->route('admin.dashboard'),
                'anfitrion' => redirect()->route('anfitrion.dashboard'),
                'viajero' => redirect()->route('viajero.dashboard'),
                default => redirect()->route('login'),
            };
        }
        return $next($request);
    }
}