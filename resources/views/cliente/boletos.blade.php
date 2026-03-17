@extends('layouts.app')

@section('content')
<h1 style="text-align:center;">Mis Boletos</h1>

@if($boletos->isEmpty())
    <p style="text-align:center; color:gray;">No tienes boletos comprados.</p>
@else
    <table class="table-funciones">
        <thead>
            <tr>
                <th>Película</th>
                <th>Sala</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($boletos as $boleto)
                <tr>
                    <td>{{ $boleto->funcion->pelicula->titulo }}</td>
                    <td>{{ $boleto->funcion->sala }}</td>
                    <td>{{ $boleto->funcion->fecha }}</td>
                    <td>{{ $boleto->funcion->hora }}</td>
                    <td>${{ number_format($boleto->funcion->precio, 2) }}</td>
                    <td>{{ $boleto->cantidad }}</td>
                    <td>${{ number_format($boleto->cantidad * $boleto->funcion->precio, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
