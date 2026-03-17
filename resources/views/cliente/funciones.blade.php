@extends('layouts.app')

@section('content')
<h1 style="text-align:center; margin-bottom:20px;">🎬 Funciones disponibles</h1>

@if(session('success'))
    <div style="color:green; margin-bottom:20px; text-align:center;">
        {{ session('success') }}
    </div>
@endif

@if($funciones->isEmpty())
    <p style="text-align:center; margin-top:20px;">No hay funciones disponibles actualmente.</p>
@else
    <table class="table-funciones">
        <thead>
            <tr>
                <th>Película</th>
                <th>Sala</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Precio</th>
                <th>Asientos disponibles</th>
                <th>Comprar</th>
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
                <td>{{ $funcion->asientos_disponibles }}</td>
                <td>
                    @if($funcion->asientos_disponibles > 0)
                        <a href="{{ route('cliente.comprar', $funcion->id) }}" class="button" style="background-color:#4CAF50;">Comprar</a>
                    @else
                        <span style="color:red;">Agotada</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
