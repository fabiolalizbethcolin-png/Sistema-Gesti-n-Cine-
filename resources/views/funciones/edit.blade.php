@extends('layouts.app')

@section('content')
<div class="auth-container">
    <h1>Editar Función</h1>

    <form action="{{ route('funciones.update', $funcion->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- PELÍCULA --}}
        <div>
            <label>Película:</label>
            <select name="pelicula_id">
                <option value="">Seleccione</option>
                @foreach($peliculas as $pelicula)
                    <option value="{{ $pelicula->id }}" {{ (session('old')['pelicula_id'] ?? $funcion->pelicula_id) == $pelicula->id ? 'selected' : '' }}>
                        {{ $pelicula->titulo }}
                    </option>
                @endforeach
            </select>
            @if(session('errors')['pelicula_id'] ?? false)
                <small style="color:red;">{{ session('errors')['pelicula_id'] }}</small>
            @endif
        </div>

        {{-- SALA --}}
        <div>
            <label>Sala:</label>
            <input type="text" name="sala" value="{{ session('old')['sala'] ?? $funcion->sala }}">
            @if(session('errors')['sala'] ?? false)
                <small style="color:red;">{{ session('errors')['sala'] }}</small>
            @endif
        </div>

        {{-- FECHA --}}
        <div>
            <label>Fecha:</label>
            <input type="date" name="fecha" value="{{ session('old')['fecha'] ?? $funcion->fecha }}">
            @if(session('errors')['fecha'] ?? false)
                <small style="color:red;">{{ session('errors')['fecha'] }}</small>
            @endif
        </div>

        {{-- HORA --}}
        <div>
            <label>Hora:</label>
            <input type="time" name="hora" value="{{ session('old')['hora'] ?? $funcion->hora }}">
            @if(session('errors')['hora'] ?? false)
                <small style="color:red;">{{ session('errors')['hora'] }}</small>
            @endif
        </div>

        {{-- PRECIO --}}
        <div>
            <label>Precio:</label>
            <input type="number" name="precio" value="{{ session('old')['precio'] ?? $funcion->precio }}">
            @if(session('errors')['precio'] ?? false)
                <small style="color:red;">{{ session('errors')['precio'] }}</small>
            @endif
        </div>

        <button type="submit" style="margin-top:15px;">Actualizar Función</button>
    </form>
</div>
@endsection
