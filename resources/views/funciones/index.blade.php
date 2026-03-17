@extends('layouts.app')

@section('content')
<h1 style="text-align:center; margin-bottom:20px;">Funciones</h1>

<div style="text-align:center; margin-bottom:20px;">
    <a href="{{ route('funciones.create') }}" class="button">Agregar Función</a>
</div>

@if(session('success'))
    <div style="color:green; margin-bottom:20px; text-align:center;">
        {{ session('success') }}
    </div>
@endif

<table class="table-funciones">
    <thead>
        <tr>
            <th>Película</th>
            <th>Sala</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Precio</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($funciones as $funcion)
        <tr>
            <td>{{ $funcion->pelicula->titulo }}</td>
            <td>{{ $funcion->sala }}</td>
            <td>{{ $funcion->fecha }}</td>
            <td>{{ $funcion->hora }}</td>
            <td>${{ number_format($funcion->precio, 2) }}</td>
            <td>{{ $funcion->activo ? 'Activo' : 'Inactivo' }}</td>
            <td style="display:flex; gap:5px; align-items:center;">
                <a href="{{ route('funciones.edit', $funcion->id) }}" class="button" style="background-color:#4CAF50;">Editar</a>

                @if($funcion->activo)
                    <form action="{{ route('funciones.desactivar', $funcion->id) }}" method="POST" style="margin:0;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="button" style="background-color:#FFA500;">Desactivar</button>
                    </form>
                @else
                    <form action="{{ route('funciones.activar', $funcion->id) }}" method="POST" style="margin:0;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="button" style="background-color:#008CBA;">Activar</button>
                    </form>
                @endif

                <form action="{{ route('funciones.destroy', $funcion->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta función?');" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button" style="background-color:#f44336;">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
