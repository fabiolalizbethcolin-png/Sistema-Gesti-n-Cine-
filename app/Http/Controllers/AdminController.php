<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IntentoLogin;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Mostrar formulario con SOLO usuarios bloqueados
    public function unlockForm()
    {
        // Obtener solo usuarios que tengan bloqueado_hasta mayor al tiempo actual
        $bloqueados = IntentoLogin::whereNotNull('bloqueado_hasta')
            ->where('bloqueado_hasta', '>', Carbon::now())
            ->get();

        return view('unban', compact('bloqueados'));
    }

    // Quitar bloqueo
    public function unlockUser(Request $request)
    {
        $intento = IntentoLogin::where('correo', $request->email)->first();

        if (!$intento) {
            return back()->with('error', 'El usuario no tiene registro de intentos.');
        }

        // Resetear bloqueo
        $intento->bloqueado_hasta = null;
        $intento->intentos = 0;
        $intento->save();

        return back()->with('success', 'Usuario desbloqueado correctamente.');
    }
}
