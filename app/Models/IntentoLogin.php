<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntentoLogin extends Model
{
    protected $table = 'intento_logins'; // Nombre de la tabla en español
    protected $fillable = [
        'correo',
        'intentos',
        'ultimo_intento',
        'bloqueado_hasta'
    ];
}
