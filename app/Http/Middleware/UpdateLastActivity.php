<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UpdateLastActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Solo si es la misma sesión
            if ($user->session_id === session()->getId()) {
                $user->last_activity = now();
                $user->save();
            }
        }

        return $next($request);
    }
}
