<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    use HasFactory;

    protected $table = 'suscripciones';

    protected $fillable = [
        'plan',
        'fecha_inicio',
        'fecha_fin',
        'activa',
        'fk_idusuarios'
    ];
    // 👇 Esto convierte automáticamente fecha_inicio y fecha_fin en Carbon
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'activa' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'fk_idusuarios');
    }
}