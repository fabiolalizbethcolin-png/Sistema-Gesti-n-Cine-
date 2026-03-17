@extends('layouts.app')

@section('content')
<div class="auth-container">

    <h1>Desbloquear Usuario</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div style="color:green; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Mensaje de error --}}
    @if(session('error'))
        <div style="color:red; margin-bottom:10px;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.unlockUser') }}" method="POST">
        @csrf

        <label>Selecciona un usuario bloqueado:</label>

        <select name="email" required>
            <option value="">-- Selecciona --</option>

            @foreach($bloqueados as $item)
                <option value="{{ $item->correo }}">
                    {{ $item->correo }} (Bloqueado hasta: {{ \Carbon\Carbon::parse($item->bloqueado_hasta)->format('H:i d-m-Y') }})
                </option>
            @endforeach

        </select>

        <button type="submit" style="margin-top:15px;">Desbloquear Usuario</button>
    </form>
</div>
@endsection
