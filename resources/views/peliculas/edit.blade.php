@extends('layouts.app')

@section('content')
<div class="auth-container">
    <h1>Editar Película</h1>

    <form action="{{ route('peliculas.update', $pelicula->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- TÍTULO --}}
        <div>
            <label>Título:</label>
            <input type="text" name="titulo" value="{{ session('old')['titulo'] ?? $pelicula->titulo }}">
            @if(session('errors')['titulo'] ?? false)
                <small style="color:red;">{{ session('errors')['titulo'] }}</small>
            @endif
        </div>

        {{-- GÉNERO --}}
        <div>
            <label>Género:</label>
            <input type="text" name="genero" value="{{ session('old')['genero'] ?? $pelicula->genero }}">
            @if(session('errors')['genero'] ?? false)
                <small style="color:red;">{{ session('errors')['genero'] }}</small>
            @endif
        </div>

        {{-- DURACIÓN --}}
        <div>
            <label>Duración (min):</label>
            <input type="number" name="duracion" value="{{ session('old')['duracion'] ?? $pelicula->duracion }}">
            @if(session('errors')['duracion'] ?? false)
                <small style="color:red;">{{ session('errors')['duracion'] }}</small>
            @endif
        </div>

        {{-- DESCRIPCIÓN --}}
        <div>
            <label>Descripción:</label>
            <textarea name="descripcion" style="width:100%; padding:6px 8px; font-size:16px; border-radius:4px; border:1px solid #ccc; box-sizing:border-box;">{{ session('old')['descripcion'] ?? $pelicula->descripcion }}</textarea>
            @if(session('errors')['descripcion'] ?? false)
                <small style="color:red;">{{ session('errors')['descripcion'] }}</small>
            @endif
        </div>

        {{-- CLASIFICACIÓN --}}
        <div>
            <label>Clasificación:</label>
            <input type="text" name="clasificacion" value="{{ session('old')['clasificacion'] ?? $pelicula->clasificacion }}">
            @if(session('errors')['clasificacion'] ?? false)
                <small style="color:red;">{{ session('errors')['clasificacion'] }}</small>
            @endif
        </div>

        {{-- IDIOMA --}}
        <div>
            <label>Idioma original:</label>
            <input type="text" name="idioma" value="{{ session('old')['idioma'] ?? $pelicula->idioma }}">
            @if(session('errors')['idioma'] ?? false)
                <small style="color:red;">{{ session('errors')['idioma'] }}</small>
            @endif
        </div>

        {{-- IMAGEN --}}
        <div>
            <label>Imagen:</label>
            @if($pelicula->imagen)
                <img src="{{ asset('storage/' . $pelicula->imagen) }}" width="150"><br>
            @endif
            <input type="file" name="imagen" accept="image/*">
        </div>

        <button type="submit" style="margin-top:15px;">Actualizar Película</button>
    </form>
</div>
@endsection
