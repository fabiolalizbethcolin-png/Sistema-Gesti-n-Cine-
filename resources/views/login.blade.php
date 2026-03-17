@extends('layouts.app')

@section('content')
<div class="auth-container">
    <h1>Iniciar Sesión</h1>

    {{-- Error normal --}}
    @if(session('error'))
        <div style="color:red; margin-bottom:15px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Mensaje de bloqueo CORRECTO --}}
    @if(session('bloqueado_timer'))
        <div style="color:red; margin-bottom:15px; font-size:18px;">
            Tu cuenta está bloqueada temporalmente.<br>
            Quedan: <strong>{{ session('bloqueado_timer') }}</strong> minutos
        </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf

        <div>
            <label>Correo Electrónico:</label>
            <input type="text" name="email" value="{{ old('email') }}">
            @error('email')
                <small style="color:red;">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-top:10px;">
            <label>Contraseña:</label>
            <input type="password" name="password">
            @error('password')
                <small style="color:red;">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" style="margin-top:15px;">Ingresar</button>
    </form>

    <p class="register-link">
        ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
    </p>
</div>
@endsection
