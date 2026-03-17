@extends('layouts.app')

@section('content')

<div class="inicio-container">

    <section class="hero-section">
        <h1 class="hero-title">🎬 Bienvenido al Cine</h1>
        <p class="hero-subtitle">Explora nuestras películas y disfruta la experiencia.</p>
    </section>

    <h2 class="section-title">Películas disponibles</h2>

    @if($peliculas->isEmpty())
        <p>No hay películas registradas aún.</p>
    @else
        <div class="peliculas-grid">
            @foreach($peliculas as $pelicula)
                <div class="pelicula-card">
                    @if($pelicula->imagen)
                        <img src="{{ asset('storage/' . $pelicula->imagen) }}" 
                             alt="{{ $pelicula->titulo }}">
                    @else
                        <div style="width:150px; height:250px; background-color:#eee; display:flex; align-items:center; justify-content:center; border-radius:5px;">
                            Sin Imagen
                        </div>
                    @endif
                    <h3>{{ $pelicula->titulo }}</h3>
                    <p>Duración: {{ $pelicula->duracion }} min</p>
                    <p>
                        @if($pelicula->disponible)
                            <span style="color: green; font-weight: bold;">Disponible</span>
                        @else
                            <span style="color: red; font-weight: bold;">No disponible</span>
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection
