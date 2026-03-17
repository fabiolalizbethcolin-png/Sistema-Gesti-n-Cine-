@extends('layouts.app')

@section('content')

<h1 style="text-align:center; margin-bottom:20px;">🎬 Cartelera</h1>

@if($peliculas->isEmpty())
    <p style="text-align:center;">No hay películas disponibles.</p>
@else
    <div class="peliculas-grid">
        @foreach($peliculas as $pelicula)
            <div class="pelicula-card">
                @if($pelicula->imagen)
                    <img src="{{ asset('storage/' . $pelicula->imagen) }}" alt="{{ $pelicula->titulo }}">
                @else
                    <div style="width:150px; height:250px; background-color:#eee; display:flex; align-items:center; justify-content:center; border-radius:5px;">
                        Sin Imagen
                    </div>
                @endif
                <h3>{{ $pelicula->titulo }}</h3>
                <p>Duración: {{ $pelicula->duracion }} min</p>
                <a href="{{ route('cliente.funciones', $pelicula->id) }}" class="button">Ver funciones</a>
            </div>
        @endforeach
    </div>
@endif

@endsection
