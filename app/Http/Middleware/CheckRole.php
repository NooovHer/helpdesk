<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Asegurarse de que el usuario está autenticado
        if (!Auth::check()) {
            abort(403, 'Acceso no autorizado');
        }

        $user = Auth::user();

        // Si el usuario tiene alguno de los roles requeridos
        foreach ($roles as $role) {
            // Opción A: Si 'role' es el nombre del rol directamente
            if ($user->role === $role) {
                return $next($request);
            }
            
            // Opción B: Si tienes una relación con modelo Role
            // if ($user->role && $user->role->name === $role) {
            //     return $next($request);
            // }

            // Opción C: Si tienes un método hasRole
            // if ($user->hasRole($role)) {
            //     return $next($request);
            // }
        }

        // Si no coincide ningún rol, abortamos
        abort(403, 'Acceso no autorizado');
    }
}
