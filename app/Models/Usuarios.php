<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuarios extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'email',
        'password',
        'fk_idpersonas',
        'fk_idempresas',
        'fk_idtipousuarios',
    ];

    public function personas()
    {
        return $this->belongsTo(Personas::class, 'fk_idpersonas');
    }

    public function empresas()
    {
        return $this->belongsTo(Empresas::class, 'fk_idempresas');
    }

    public function tipousuarios()
    {
        return $this->belongsTo(TipoUsuarios::class, 'fk_idtipousuarios');
    }

    public function suscripcion()
    {
        return $this->hasOne(Suscripcion::class, 'usuario_id');
    }


    // public function suscripcionActiva()
    // {
    //     return $this->hasOne(Suscripcion::class, 'usuario_id')->where('activa', true)->latestOfMany();
    // }
}
