<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['nombre', 'precio', 'duracion_dias', 'limite_paquetes'];

    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class);
    }
}
