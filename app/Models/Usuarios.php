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
        return $this->hasOne(Suscripcion::class, 'fk_idusuarios');
    }


    public function getDisplayNameAttribute()
    {
        if ($this->tipousuarios && strtolower($this->tipousuarios->tipousu) === 'nameempresa') {
            return $this->empresas?->nombre_empresa ?? 'Empresa sin nombre';
        }
        return $this->personas ? $this->personas->nombres . ' ' . $this->personas->apellidos : $this->name;
    }

    public function getDisplayLogoAttribute()
    {
        if ($this->tipousuarios && strtolower($this->tipousuarios->tipousu) === 'nameempresa') {
            return $this->empresas?->logo_url; // asegúrate de tener esta columna en empresas
        }
        return $this->profile_photo_url;
    }
}
