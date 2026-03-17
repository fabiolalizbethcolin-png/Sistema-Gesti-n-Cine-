<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\IntentoLogin;
use Carbon\Carbon;

class AuthController extends Controller
{
    // ============================================
    // REGISTRO
    // ============================================
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'    => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => ['required', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/'],
        ], [
            'nombre.required'    => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'email.required'     => 'El correo es obligatorio.',
            'email.email'        => 'El correo debe incluir un @ válido.',
            'email.unique'       => 'Este correo ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex'     => 'Debe tener mayúscula, minúscula, número, símbolo y mínimo 8 caracteres.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'nombre'   => $request->nombre,
            'apellido' => $request->apellidos,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // LOG → Nuevo registro
        Log::info("Nuevo usuario registrado", [
            'email' => $request->email,
            'fecha' => now()
        ]);

        return redirect()->route('login')->with('success', 'Cuenta creada correctamente. Ahora puedes iniciar sesión.');
    }

    // ============================================
    // LOGIN + BLOQUEO POR INTENTOS + SESIÓN ÚNICA
    // ============================================
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $correo = $request->email;
        $user = User::where('email', $correo)->first();

        // 1. Manejo del bloqueo por intentos (IntentoLogin Model)
        $intento = IntentoLogin::firstOrCreate(
            ['correo' => $correo],
            [
                'intentos' => 0,
                'ultimo_intento' => null,
                'bloqueado_hasta' => null
            ]
        );

        if ($intento->bloqueado_hasta) {
            $fin = Carbon::parse($intento->bloqueado_hasta);
            $ahora = Carbon::now();
            $totalSegundos = $fin->timestamp - $ahora->timestamp;

            if ($totalSegundos <= 0) {
                // Desbloquear
                $intento->bloqueado_hasta = null;
                $intento->intentos = 0;
                $intento->save();
            } else {
                // LOG → intento de login estando bloqueado
                Log::warning("Intento de login mientras está bloqueado", [
                    'email' => $correo,
                    'bloqueado_hasta' => $fin
                ]);

                // Mostrar tiempo restante
                $minutos = str_pad(floor($totalSegundos / 60), 2, "0", STR_PAD_LEFT);
                $segundos = str_pad($totalSegundos % 60, 2, "0", STR_PAD_LEFT);
                $timer = "$minutos:$segundos";
                return back()->with('bloqueado_timer', $timer);
            }
        }
        
        // El usuario debe existir en la base de datos para continuar.
        if (!$user) {
            $intento->intentos += 1;
            $intento->ultimo_intento = Carbon::now();

            if ($intento->intentos >= 5) {
                $intento->bloqueado_hasta = Carbon::now()->addMinutes(20);
                $intento->intentos = 0;
            }
            $intento->save();

            // LOG → intento fallido (correo no registrado)
            Log::warning("Intento de login fallido (correo no registrado)", [
                'email' => $correo
            ]);

            return back()->with('error', 'Correo o contraseña incorrectos.');
        }

        // 2. Control de Sesión Única
        if ($user->session_id && $user->last_activity && $user->last_activity->diffInMinutes(now()) < 10) {
            // LOG → sesión bloqueada por sesión activa
            Log::warning("Intento de login rechazado (sesión única activa)", [
                'email' => $correo,
                'ultima_actividad' => $user->last_activity
            ]);

            return back()->with('error', 'Ya hay una sesión activa en otro navegador. Intenta nuevamente en unos minutos o cierra la sesión anterior.');
        }

        // 3. Intento de Login
        if (!Auth::attempt($request->only('email', 'password'))) {
            $intento->intentos += 1;
            $intento->ultimo_intento = Carbon::now();

            // LOG → contraseña incorrecta
            Log::warning("Intento de login fallido (contraseña incorrecta)", [
                'email' => $correo
            ]);

            if ($intento->intentos >= 5) {
                $intento->bloqueado_hasta = Carbon::now()->addMinutes(20);
                $intento->intentos = 0;
                $intento->save();
                return back()->with('bloqueado_timer', "20:00");
            }

            $intento->save();
            return back()->with('error', 'Correo o contraseña incorrectos.');
        }

        // 4. LOGIN EXITOSO
        $intento->intentos = 0;
        $intento->bloqueado_hasta = null;
        $intento->save();

        $request->session()->regenerate();

        $user->session_id = session()->getId();
        $user->last_activity = now();
        $user->save();

        // LOG → LOGIN EXITOSO
        Log::info("Usuario inició sesión", [
            'email' => $user->email,
            'fecha' => now(),
            'ip' => $request->ip()
        ]);

        return redirect('/');
    }

    // ============================================
    // LOGOUT
    // ============================================
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // LOG → CIERRE DE SESIÓN
            Log::info("Usuario cerró sesión", [
                'email' => $user->email,
                'fecha' => now()
            ]);

            $user->session_id = null;
            $user->last_activity = null;
            $user->save();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
