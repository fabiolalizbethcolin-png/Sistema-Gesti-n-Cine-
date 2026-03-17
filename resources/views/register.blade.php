@extends('layouts.app')

@section('content')
<div class="auth-container">
    <h1>Registrarse</h1>

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf

        {{-- NOMBRE --}}
        <div>
            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}">

            @error('nombre')
                <small style="color:red;">{{ $message }}</small>
            @enderror
        </div>

        {{-- APELLIDOS --}}
        <div style="margin-top:10px;">
            <label>Apellidos:</label>
            <input type="text" name="apellidos" value="{{ old('apellidos') }}">

            @error('apellidos')
                <small style="color:red;">{{ $message }}</small>
            @enderror
        </div>

        {{-- EMAIL --}}
        <div style="margin-top:10px;">
            <label>Correo Electrónico:</label>
            <input type="text" name="email" value="{{ old('email') }}">

            @error('email')
                <small style="color:red;">{{ $message }}</small>
            @enderror
        </div>

        {{-- PASSWORD --}}
        <div style="margin-top:10px;">
            <label>Contraseña:</label>
            <input type="password" name="password">

            @error('password')
                <small style="color:red;">{{ $message }}</small>
            @enderror
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div style="margin-top:10px;">
            <label>Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation">

            @error('password_confirmation')
                <small style="color:red;">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" style="margin-top:15px;">Registrarse</button>
    </form>

    <p class="login-link">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
    </p>
</div>
@endsection
