<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;

    protected $fillable = [
    'titulo', 'genero', 'duracion', 'descripcion', 
    'clasificacion', 'idioma', 'estreno', 'imagen', 'disponible'];

}
