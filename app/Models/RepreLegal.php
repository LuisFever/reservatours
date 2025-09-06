<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepreLegal extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'reprelegal';

    protected $fillable = [
        'fecha','fk_idempresas','fk_idpersonas'	
    ];

    public function empresas(){
        return $this->belongsTo(Empresas::class, 'fk_idempresas');
    }

    public function personas(){
        return $this->belongsTo(Personas::class, 'fk_idpersonas');
    }
}