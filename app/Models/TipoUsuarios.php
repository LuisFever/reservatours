<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoUsuarios extends Model
{
    use HasFactory;

    protected $table = 'tipousuarios';
    protected $fillable = [
        'tipousu',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'fk_idtipousuarios');
    }
}
