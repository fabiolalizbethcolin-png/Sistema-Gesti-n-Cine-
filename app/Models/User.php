<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'is_admin',
        'is_blocked',
        'last_activity',
        'session_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'session_token',
    ];

    /**
     * Casts automáticos a tipos nativos
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_activity'     => 'datetime',
            'is_admin'          => 'boolean',
            'is_blocked'        => 'boolean',
            'password'          => 'hashed',
        ];
    }

    /**
     * Relación con boletos
     */
    public function boletos()
    {
        return $this->hasMany(Boleto::class);
    }
}
