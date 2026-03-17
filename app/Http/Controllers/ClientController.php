<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Funcion;
use App\Models\Boleto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    // ===========================
    // CARTELERA
    // ===========================
    public function cartelera()
    {
        // Traer solo películas disponibles
        $peliculas = Pelicula::where('disponible', true)->get();
        return view('cliente.cartelera', compact('peliculas'));
    }

    // ===========================
    // FUNCIONES DISPONIBLES
    // ===========================
    public function funciones()
    {
        // Traer funciones activas y cuya película también esté disponible
        $funciones = Funcion::with('pelicula', 'boletos')
            ->where('activo', true)
            ->whereHas('pelicula', function ($query) {
                $query->where('disponible', true);
            })
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        // Calcular asientos disponibles
        foreach ($funciones as $funcion) {
            $vendidos = $funcion->boletos->sum('cantidad');
            $funcion->asientos_disponibles = $funcion->total_asientos - $vendidos;
        }

        return view('cliente.funciones', compact('funciones'));
    }

    // ===========================
    // PÁGINA DE COMPRA
    // ===========================
    public function comprar($funcion_id)
    {
        $funcion = Funcion::with('pelicula', 'boletos')->findOrFail($funcion_id);

        // Validar que la función esté activa y la película disponible
        if (!$funcion->activo || !$funcion->pelicula->disponible) {
            return redirect()->route('cliente.funciones')
                ->with('error', 'Esta función no está disponible.');
        }

        $vendidos = $funcion->boletos->sum('cantidad');
        $funcion->asientos_disponibles = $funcion->total_asientos - $vendidos;

        return view('cliente.comprar', compact('funcion'));
    }

    // ===========================
    // GUARDAR COMPRA
    // ===========================
    public function guardarCompra(Request $request, $funcion_id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1|max:10',
        ]);

        $funcion = Funcion::with('boletos', 'pelicula')->findOrFail($funcion_id);

        // Validar que la función esté activa y la película disponible
        if (!$funcion->activo || !$funcion->pelicula->disponible) {
            return redirect()->route('cliente.funciones')
                ->with('error', 'Esta función no está disponible.');
        }

        $vendidos = $funcion->boletos->sum('cantidad');
        $disponibles = $funcion->total_asientos - $vendidos;

        if ($request->cantidad > $disponibles) {
            return back()->with('error', 'No hay suficientes asientos disponibles.');
        }

        Boleto::create([
            'user_id' => Auth::id(),
            'funcion_id' => $funcion_id,
            'cantidad' => $request->cantidad,
        ]);

        return redirect()->route('cliente.funciones')
            ->with('success', 'Compra realizada con éxito');
    }

    // ===========================
    // BOLETOS DEL CLIENTE
    // ===========================
    public function boletos()
    {
        $boletos = Boleto::with('funcion.pelicula')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cliente.boletos', compact('boletos'));
    }
}
