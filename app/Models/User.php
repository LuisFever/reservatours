<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'fk_idpersonas',
        'fk_idtipousuarios',
        'intentos_fallidos',
        'bloqueado_hasta',
        'estado_usu',
        'ultimo_acceso'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'bloqueado_hasta' => 'datetime',
            'ultimo_acceso' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define la relación con el modelo TipoUsuario.
     * Un usuario pertenece a un tipo de usuario.
     */
    public function tipousuarios()
    {
        return $this->belongsTo(TipoUsuarios::class, 'fk_idtipousuarios');
    }
    public function personas()
    {
        return $this->belongsTo(Personas::class, 'fk_idpersonas');
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
