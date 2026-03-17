@extends('layouts.app')

@section('content')
<div class="auth-container">

    <h1>Comprar Boleto</h1>

    <!-- INFO DE LA FUNCIÓN -->
    <div style="margin-bottom:20px;">
        <p><strong>Película:</strong> {{ $funcion->pelicula->titulo }}</p>
        <p><strong>Sala:</strong> {{ $funcion->sala }}</p>
        <p><strong>Fecha:</strong> {{ $funcion->fecha }}</p>
        <p><strong>Hora:</strong> {{ $funcion->hora }}</p>
        <p><strong>Asientos disponibles:</strong> {{ $funcion->asientos_disponibles }}</p>
    </div>

    <form action="{{ route('cliente.comprar.guardar', $funcion->id) }}" method="POST">
        @csrf

        {{-- PRECIO UNITARIO --}}
        <div>
            <label>Precio por boleto:</label>
            <input type="text" id="precio_unit" value="{{ $funcion->precio }}" readonly>
        </div>

        {{-- CANTIDAD CON + y - --}}
        <div style="margin-top:15px;">
            <label>Cantidad:</label>

            <div style="display:flex; gap:10px; align-items:center;">

                <button type="button" id="btnRestar"
                    style="width:40px; height:40px; border:none; background:#d9534f; color:white; font-size:22px; border-radius:6px;">
                    −
                </button>

                <input type="number" id="cantidad" name="cantidad"
                       min="1"
                       max="{{ $funcion->asientos_disponibles }}"
                       value="1"
                       style="width:70px; text-align:center;">

                <button type="button" id="btnSumar"
                    style="width:40px; height:40px; border:none; background:#5cb85c; color:white; font-size:22px; border-radius:6px;">
                    +
                </button>

            </div>
        </div>

        {{-- TOTAL --}}
        <div style="margin-top:15px;">
            <label>Total a pagar:</label>
            <input type="text" id="total" value="{{ $funcion->precio }}" readonly>
        </div>

        {{-- BOTONES --}}
        <div style="margin-top:20px; display:flex; justify-content:space-between;">
            <a href="{{ route('cliente.funciones') }}"
               style="padding:10px 20px; background:#6c757d; color:white; text-decoration:none; border-radius:5px;">
               Cancelar
            </a>

            <button type="submit"
                style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px;">
                Comprar
            </button>
        </div>

    </form>
</div>

{{-- Archivo JS --}}
<script src="{{ asset('js/main.js') }}"></script>

@endsection
