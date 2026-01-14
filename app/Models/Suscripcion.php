<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Suscripcion extends Model
{
    use HasFactory;

    protected $table = 'suscripciones';

    // Usar los nombres reales de columnas en la BD
    protected $fillable = [
        'tipo_suscripcion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'fk_idusuarios',
    ];

    // Convertir fechas y estado
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'estado' => 'boolean',
    ];

    // Accesores / mutators opcionales para mantener compatibilidad con código
    public function getPlanAttribute()
    {
        return $this->attributes['tipo_suscripcion'] ?? null;
    }

    public function setPlanAttribute($value)
    {
        $this->attributes['tipo_suscripcion'] = $value;
    }

    public function getActivaAttribute()
    {
        return isset($this->attributes['estado']) ? (bool) $this->attributes['estado'] : null;
    }

    public function setActivaAttribute($value)
    {
        $this->attributes['estado'] = (bool) $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_idusuarios');
    }
}