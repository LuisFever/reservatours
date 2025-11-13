<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'empresas';

    protected $fillable = [
        'nameempresa','razonsocial','ruc','direccion','telefono','logo'
    ];

    public function reprelegal()
    {
        return $this->hasMany(RepreLegal::class, 'fk_idempresas');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'fk_idempresas'); 
    }

}