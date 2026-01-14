<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Personas;
use App\Models\RepreLegal;
use App\Models\Empresas;

class Dashboard extends Component
{
    public $userType;
    public $userName;
    public $cards = [];
    public $registro;
    public $registro_type;

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }

    public function mount()
    {
        $user = Auth::user();

        $this->userType = $user->tipousuarios?->tipousu ? strtolower($user->tipousuarios->tipousu) : null;

        // Definimos las tarjetas base que pueden ser usadas por varios roles
        $allCards = [
            'explorar' => [
                'title' => 'Explorar Destinos',
                'text' => 'Descubre lugares increíbles',
                'icon' => 'fas fa-map-marked-alt',
                'color' => 'blue',
                'route' => route('inicio'),
                'linkText' => 'Ver destinos →',
            ],
            'perfil' => [
                'title' => 'Mi Perfil',
                'text' => 'Gestiona tu cuenta',
                'icon' => 'fas fa-user',
                'color' => 'gray',
                'route' => '',
                'linkText' => 'Ver perfil →',
            ],
            'favoritos' => [
                'title' => 'Favoritos',
                'text' => 'Tus destinos favoritos',
                'icon' => 'fas fa-heart',
                'color' => 'red',
                'route' => '#',
                'linkText' => 'Ver favoritos →',
            ],
            'reservas' => [
                'title' => 'Mis Reservas',
                'text' => 'Gestiona tus viajes',
                'icon' => 'fas fa-ticket-alt',
                'color' => 'green',
                'route' => '#',
                'linkText' => 'Ver reservas →',
            ],
            // Tarjetas exclusivas para SuperAdmin
            'usuarios' => [
                'title' => 'Usuarios',
                'text' => 'Tus usuarios registrados',
                'icon' => 'fas fa-users',
                'color' => 'green',
                'route' => route('admin.vistausuarios'),
                'linkText' => 'Ver usuarios →',
            ],
            'empresas' => [
                'title' => 'Empresas',
                'text' => 'Conoce nuestros socios',
                'icon' => 'fas fa-building',
                'color' => 'indigo',
                'route' => '',
                'linkText' => 'Ver empresas →',
            ],
            'reportes' => [
                'title' => 'Reportes',
                'text' => 'Tus reportes generados',
                'icon' => 'fas fa-chart-line',
                'color' => 'blue',
                'route' => '#',
                'linkText' => 'Ver reportes →',
            ],
            'soporte' => [
                'title' => 'Soporte y Feedback',
                'text' => 'Tus reportes generados',
                'icon' => 'fas fa-headset',
                'color' => 'teal',
                'route' => '#',
                'linkText' => 'Ver reportes →',
            ],
            'configuracion' => [
                'title' => 'Configuraciones',
                'text' => 'Tus reportes generados',
                'icon' => 'fas fa-cogs',
                'color' => 'gray',
                'route' => '#',
                'linkText' => 'Ver reportes →',
            ],
            'marketing' => [
                'title' => 'Métricas de Marketing',
                'text' => 'Tus reportes generados',
                'icon' => 'fas fa-chart-line',
                'color' => 'red',
                'route' => '#',
                'linkText' => 'Ver reportes →',
            ],
            'contenidos' => [
                'title' => 'Gestión de Contenidos',
                'text' => 'Tus reportes generados',
                'icon' => 'fas fa-folder-open',
                'color' => 'pink',
                'route' => '#',
                'linkText' => 'Ver reportes →',
            ],
            'sesiones' => [
                'title' => 'Sesiones de Administración',
                'text' => 'Tus reportes generados',
                'icon' => 'fas fa-user-shield',
                'color' => 'orange-600',
                'route' => '#',
                'linkText' => 'Ver reportes →',
            ],
        ];

        // Cargar registro asociado (persona o empresa via reprelegal)
        $this->registro = null;
        $this->registro_type = null;
        $persona = $user->personas ?? null;
        if ($persona) {
            $repre = RepreLegal::where('fk_idpersonas', $persona->id)->first();
            if ($repre) {
                $empresa = Empresas::find($repre->fk_idempresas);
                if ($empresa) {
                    $this->registro_type = 'empresa';
                    $this->registro = [
                        'nameempresa' => $empresa->nameempresa,
                        'razonsocial' => $empresa->razonsocial,
                        'ruc' => $empresa->ruc,
                        'direccion' => $empresa->direccion,
                        'telefono' => $empresa->telefono,
                    ];
                }
            }
            if (!$this->registro) {
                $this->registro_type = 'persona';
                $this->registro = [
                    'dni' => $persona->dni,
                    'nombres' => $persona->nombres,
                    'apellidos' => $persona->apellidos,
                    'celular' => $persona->celular,
                ];
            }
        }

        // Configuramos el dashboard según el tipo de usuario
        if ($this->userType === 'cliente') {
            $this->userName = $user->personas?->nombres ?? $user->name;
            $this->cards = [$allCards['explorar'], $allCards['reservas'], $allCards['empresas'], $allCards['perfil'], $allCards['favoritos']];
        } elseif ($this->userType === 'empresa') {
            $this->userName = $this->registro_type === 'empresa' ? ($this->registro['nameempresa'] ?? $user->name) : ($user->personas?->nombres ?? $user->name);
            $this->cards = [$allCards['explorar'], $allCards['reservas'], $allCards['empresas'], $allCards['perfil']];
        } elseif ($this->userType === 'superadmin') {
            $this->userName = 'SuperAdmin';
            $this->cards = [$allCards['usuarios'], $allCards['empresas'], $allCards['reportes'], $allCards['soporte'], $allCards['configuracion'], $allCards['marketing'], $allCards['contenidos'], $allCards['sesiones']];
        }
    }

    // Llamar a la tabla personas para obtener datos adicionales del usuario
    public function getUserTypeProperty()
    {
        $user = auth()->user();
        return $user->tipoUsuario?->tipousu ?? null;
    }
    // Lamar a la tabla usuarios para obtener datos adicionales del usuario
    // public function getUserIdProperty()
    // {
    //     $user = auth()->user();
    //     return $user->usuarios?->fk_idtipousuarios ?? null;
    // }
    // Llamar a la tabla RepreLegal para obtener datos adicionales del usuario
    public function getUserNameProperty()
    {
        $user = auth()->user();
        return $user->reprelegal?->fk_idempresas ?? null;
    }

}