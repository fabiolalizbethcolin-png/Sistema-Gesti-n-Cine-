@extends('layouts.app')

@section('content')

<h1>Películas</h1>

<table class="table-peliculas">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Título</th>
            <th>Género</th>
            <th>Duración</th>
            <th>Descripción</th>
            <th>Clasificación</th>
            <th>Idioma</th>
            <th>Disponibilidad</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peliculas as $pelicula)
        <tr>
            <td>
                @if($pelicula->imagen)
                    <img src="{{ asset('storage/' . $pelicula->imagen) }}" alt="{{ $pelicula->titulo }}" class="img-pelicula">
                @else
                    <div style="width:80px; height:120px; background-color:#eee; display:flex; align-items:center; justify-content:center; border-radius:5px;">Sin Imagen</div>
                @endif
            </td>
            <td>{{ $pelicula->titulo }}</td>
            <td>{{ $pelicula->genero }}</td>
            <td>{{ $pelicula->duracion }} min</td>
            <td>{{ $pelicula->descripcion }}</td>
            <td>{{ $pelicula->clasificacion }}</td>
            <td>{{ $pelicula->idioma }}</td>
            <td>
                @if($pelicula->disponible)
                    <span style="color: green; font-weight: bold;">Disponible</span>
                @else
                    <span style="color: red; font-weight: bold;">No disponible</span>
                @endif
            </td>
            <td style="display: flex; gap: 5px; align-items: center;">
                <!-- Editar -->
                <a href="{{ route('peliculas.edit', $pelicula->id) }}" style="padding: 5px 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px;">
                    Editar
                </a>
                
                <!-- Eliminar / Desactivar -->
                @if($pelicula->disponible)
                    <form action="{{ route('peliculas.destroy', $pelicula->id) }}" method="POST" style="margin:0; padding:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('¿Desea desactivar esta película?')"
                                style="padding: 5px 10px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            Desactivar
                        </button>
                    </form>
                @else
                    <!-- Botón Activar para restaurar -->
                    <form action="{{ route('peliculas.restore', $pelicula->id) }}" method="POST" style="margin:0; padding:0;">
                        @csrf
                        <button type="submit"
                                style="padding: 5px 10px; background-color: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            Activar
                        </button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<!-- Botón Crear al final de la tabla -->
<a href="{{ route('peliculas.create') }}"
   style="padding: 8px 15px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 4px;">
   Agregar Película
</a>

@endsection
