<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Asegurarse de que el usuario está autenticado
        if (! Auth::check()) {
            abort(403, 'Acceso no autorizado');
        }

        // Si el rol del usuario está en el array $roles, dejamos pasar
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Si no coincide, abortamos
        abort(403, 'Acceso no autorizado');
    }
}
