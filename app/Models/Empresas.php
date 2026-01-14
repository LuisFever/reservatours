<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;

class Empresas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'empresas';

    protected $fillable = [
        'nameempresa','razonsocial','ruc','direccion','telefono'
    ];

    public function reprelegal()
    {
        return $this->hasMany(RepreLegal::class, 'fk_idempresas');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'fk_idempresas'); 
    }

}