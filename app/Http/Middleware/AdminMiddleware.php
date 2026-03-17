<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario NO ha iniciado sesión
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verificar si el usuario NO es administrador
        if (!Auth::user()->is_admin) {
            return redirect()->route('inicio')->with('error', 'Acceso denegado.');
        }

        return $next($request);
    }
}
