<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcion extends Model
{
    use HasFactory;

    // Agregamos 'activo' en lugar de 'disponible'
    protected $fillable = [
        'pelicula_id', 
        'sala', 
        'fecha', 
        'hora', 
        'precio', 
        'total_asientos', 
        'activo'
    ];

    // =====================
    // RELACIONES
    // =====================

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class);
    }

    public function boletos()
    {
        return $this->hasMany(Boleto::class);
    }

    // =====================
    // CLIENTE
    // =====================

    // Calcular asientos disponibles dinámicamente
    public function getAsientosDisponiblesAttribute()
    {
        return $this->total_asientos - $this->boletos()->sum('cantidad');
    }

    // Mostrar si la función está activa
    public function getActivoLabelAttribute()
    {
        return $this->activo ? 'Activo' : 'Inactivo';
    }

    // Scope: funciones futuras
    public function scopeFuturas($query)
    {
        return $query->where('fecha', '>=', now()->format('Y-m-d'));
    }

    // Scope: funciones con asientos disponibles
    public function scopeConAsientosDisponibles($query)
    {
        return $query->whereRaw(
            'total_asientos > (SELECT COALESCE(SUM(cantidad),0) FROM boletos WHERE funcion_id = funcions.id)'
        );
    }

    // Scope: funciones activas
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }
}
