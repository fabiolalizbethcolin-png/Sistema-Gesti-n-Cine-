<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcion;
use App\Models\Pelicula;

class FuncionController extends Controller
{
    // =====================
    // ADMINISTRACIÓN
    // =====================

    public function index()
    {
        $funciones = Funcion::with('pelicula')->get();
        return view('funciones.index', compact('funciones'));
    }

    public function create()
    {
        $peliculas = Pelicula::all();
        return view('funciones.create', compact('peliculas'));
    }

    public function store(Request $request)
    {
        $errors = [];

        $pelicula_id = $request->input('pelicula_id');
        if (!$pelicula_id || !Pelicula::find($pelicula_id)) {
            $errors['pelicula_id'] = 'Seleccione una película válida';
        }

        $sala = trim($request->input('sala'));
        if (!$sala) $errors['sala'] = 'La sala es obligatoria';

        $fecha = $request->input('fecha');
        if (!$fecha || !strtotime($fecha)) $errors['fecha'] = 'Ingrese una fecha válida';

        $hora = trim($request->input('hora'));
        if (!$hora) $errors['hora'] = 'La hora es obligatoria';

        $precio = $request->input('precio');
        if (!$precio || !is_numeric($precio) || $precio <= 0) {
            $errors['precio'] = 'El precio debe ser un número mayor a 0';
        }

        if (!empty($errors)) {
            return back()->with(['errors' => $errors, 'old' => $request->all()]);
        }

        // Por defecto, al crear, la función estará activa
        $data = $request->all();
        $data['activo'] = true;

        Funcion::create($data);

        return redirect()->route('funciones.index')->with('success', 'Función creada correctamente');
    }

    public function edit($id)
    {
        $funcion = Funcion::findOrFail($id);
        $peliculas = Pelicula::all();
        return view('funciones.edit', compact('funcion', 'peliculas'));
    }

    public function update(Request $request, $id)
    {
        $errors = [];

        $pelicula_id = $request->input('pelicula_id');
        if (!$pelicula_id || !Pelicula::find($pelicula_id)) {
            $errors['pelicula_id'] = 'Seleccione una película válida';
        }

        $sala = trim($request->input('sala'));
        if (!$sala) $errors['sala'] = 'La sala es obligatoria';

        $fecha = $request->input('fecha');
        if (!$fecha || !strtotime($fecha)) $errors['fecha'] = 'Ingrese una fecha válida';

        $hora = trim($request->input('hora'));
        if (!$hora) $errors['hora'] = 'La hora es obligatoria';

        $precio = $request->input('precio');
        if (!$precio || !is_numeric($precio) || $precio <= 0) {
            $errors['precio'] = 'El precio debe ser un número mayor a 0';
        }

        if (!empty($errors)) {
            return back()->with(['errors' => $errors, 'old' => $request->all()]);
        }

        $funcion = Funcion::findOrFail($id);
        $funcion->update($request->all());

        return redirect()->route('funciones.index')->with('success', 'Función actualizada correctamente');
    }

    public function destroy($id)
    {
        Funcion::destroy($id);
        return redirect()->route('funciones.index')->with('success', 'Función eliminada correctamente');
    }

    // =====================
    // ACTIVAR / DESACTIVAR
    // =====================

    public function activar($id)
    {
        $funcion = Funcion::findOrFail($id);
        $funcion->activo = true;
        $funcion->save();

        return redirect()->route('funciones.index')->with('success', 'Función activada correctamente');
    }

    public function desactivar($id)
    {
        $funcion = Funcion::findOrFail($id);
        $funcion->activo = false;
        $funcion->save();

        return redirect()->route('funciones.index')->with('success', 'Función desactivada correctamente');
    }

    // =====================
    // CLIENTE
    // =====================

    public function funcionesDisponibles()
    {
        $funciones = Funcion::with('pelicula')
            ->futuras() // solo fechas futuras
            ->where('activo', true) // solo funciones activas
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->conAsientosDisponibles(); // filtra por asientos disponibles

        return view('cliente.funciones', compact('funciones'));
    }
}
