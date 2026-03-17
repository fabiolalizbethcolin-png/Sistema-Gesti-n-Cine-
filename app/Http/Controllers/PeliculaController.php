<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeliculaController extends Controller
{
    // Mostrar todas las películas (panel de administración)
    public function index() 
    {
        $peliculas = Pelicula::all();
        return view('peliculas.index', compact('peliculas'));
    }

    // Mostrar formulario de creación
    public function create() 
    {
        return view('peliculas.create');
    }

    // Guardar nueva película
    public function store(Request $request)
    {
        // ✅ USAR VALIDACIÓN DE LARAVEL (más limpio)
        $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string|max:100',
            'duracion' => 'required|integer|min:1',
            'clasificacion' => 'required|string|max:10',
            'idioma' => 'required|string|max:50',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'disponible' => 'sometimes|boolean',
        ]);

        // Preparar datos
        $data = $request->except('imagen'); // ✅ NO incluir el archivo en $data
        $data['disponible'] = true; // Por defecto disponible

        // ✅ Procesar imagen correctamente
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            // Guardar en storage/app/public/peliculas
            $path = $request->file('imagen')->store('peliculas', 'public');
            
            // Guardar la URL pública, NO el objeto UploadedFile
            $data['imagen'] = '/storage/' . $path;
        }

        // Crear la película
        Pelicula::create($data);

        return redirect()->route('peliculas.index')
            ->with('success', 'Película creada exitosamente');
    }

    // Mostrar formulario de edición
    public function edit($id) 
    {
        $pelicula = Pelicula::findOrFail($id);
        return view('peliculas.edit', compact('pelicula'));
    }

    // Actualizar película
    public function update(Request $request, $id) 
    {
        $pelicula = Pelicula::findOrFail($id);

        // ✅ Validación
        $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string|max:100',
            'duracion' => 'required|integer|min:1',
            'clasificacion' => 'required|string|max:10',
            'idioma' => 'required|string|max:50',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'disponible' => 'sometimes|boolean',
        ]);

        $data = $request->except('imagen');

        // ✅ Procesar nueva imagen si se subió
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            // Eliminar imagen anterior si existe
            if ($pelicula->imagen && !str_contains($pelicula->imagen, 'placeholder')) {
                $oldPath = str_replace('/storage/', '', $pelicula->imagen);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            
            // Guardar nueva imagen
            $path = $request->file('imagen')->store('peliculas', 'public');
            $data['imagen'] = '/storage/' . $path;
        }

        $pelicula->update($data);

        return redirect()->route('peliculas.index')
            ->with('success', 'Película actualizada exitosamente');
    }

    // Marcar película como no disponible (no borrar)
    public function destroy($id) 
    {
        $pelicula = Pelicula::findOrFail($id);
        $pelicula->disponible = false;
        $pelicula->save();

        return redirect()->route('peliculas.index')
            ->with('success', 'Película desactivada');
    }

    // Restaurar película (hacerla disponible)
    public function restore($id) 
    {
        $pelicula = Pelicula::findOrFail($id);
        $pelicula->disponible = true;
        $pelicula->save();

        return redirect()->back()
            ->with('success', 'Película restaurada');
    }

    // Mostrar las películas en el inicio (público)
    public function inicio() 
    {
        $peliculas = Pelicula::where('disponible', true)->get();
        return view('inicio', compact('peliculas'));
    }
}