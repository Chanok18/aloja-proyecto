<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('login');
        }

        // Obtener el usuario autenticado
        $user = Auth::user();
    
        // Verificar si el usuario tiene la propiedad 'rol'
        if (!isset($user->rol)) {
            abort(403, 'Usuario sin rol asignado.');
        }

        $userRole = $user->rol;

        // Verificar si el rol del usuario está en los roles permitidos
        if (!in_array($userRole, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
}