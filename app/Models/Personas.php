<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'personas';

    protected $fillable = [
        'dni',
        'nombres',
        'apellidos',
        'celular'
    ];

    public function reprelegal()
    {
        return $this->hasMany(RepreLegal::class, 'fk_idpersonas');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'fk_idpersonas');
    }
}
