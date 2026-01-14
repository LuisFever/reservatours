<?php

namespace App\Livewire\Admin;

use App\Models\User; // Asegúrate de importar el modelo User
use App\Models\Usuarios;
use App\Models\TipoUsuarios;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class VistaUsuarios extends Component
{
    public $tiposUsuario;
    public $modalAbierto = false;
    public $modalConfirmacion = false;
    public $editando = false;
    public $foto;
    public $usuarioEliminar;
    public $usuarioId;

    public $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'fk_idtipousuarios' => '',
        // Datos de persona
        'dni' => '',
        'nombre' => '',
        'apellidos' => '',
        'telefono' => '',
        'email_persona' => '',
    ];


    use WithPagination; // Usa el trait para que la paginación funcione
    public function render()
    {
        // Aseguramos usar los nombres de relación definidos en el modelo `User`
        $usuarios = User::with(['tipousuarios', 'personas'])
            ->where('email', '!=', 'test@example.com') // Excluimos al SuperAdmin
            // Filtrar por término de búsqueda: name, email, personas o el tipo (cliente/empresa)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhereHas('personas', function ($subQ) {
                            $subQ->where('nombres', 'like', '%' . $this->search . '%')
                                ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                                ->orWhere('dni', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('tipousuarios', function ($tq) {
                            $tq->where('tipousu', 'like', '%' . $this->search . '%');
                        });
                });
            })
            // Filtrar por el botón tipo (cliente/empresa) si se seleccionó
            ->when($this->filterTipo, function ($query) {
                $query->whereHas('tipousuarios', function ($q) {
                    $q->where('tipousu', $this->filterTipo);
                });
            })
            ->latest()
            ->paginate(5); // Puedes ajustar el número de paginación según tus necesidades

        // Retornamos la vista, pasándole la colección de usuarios
        return view('livewire.admin.vistausuarios', [
            'vistausuarios' => $usuarios,
        ])->layout('layouts.app');
    }


    public function editar($id)
    {
        $this->resetValidation();
        $usuario = User::with('personas')->findOrFail($id);
        $this->usuarioId = $id;
        $this->editando = true;
        
        $this->form = [
            'name' => $usuario->name,
            'email' => $usuario->email,
            'estado_usu' => $usuario->estado,
            'fk_idtipousu' => $usuario->fk_idtipousu,
            'password' => '',
            // Datos de persona si existe
            'dni' => $usuario->personas->dni ?? '',
            'nombre' => $usuario->personas->nombres ?? '',
            'apellidos' => $usuario->personas->apellidos ?? '',
            'telefono' => $usuario->personas->celular ?? '',
            'email_persona' => $usuario->personas->email ?? '',
        ];
        
        $this->modalAbierto = true;
    }
    public function editar1($id, $nuevoEstado = null)
    {
        $this->resetValidation();
        $usuario = User::with('personas')->findOrFail($id);
        $this->usuarioId = $id;

        // Cambiar el estado si se proporciona
        if ($nuevoEstado !== null) {
            $usuario->estado_usu = $nuevoEstado;
            $usuario->save();
        }

        $this->editando = true;

        $this->form = [

            'estado_usu' => $usuario->estado_usu,

        ];
    }
    // filtro seleccionado desde los botones (cliente|empresa|null)
    public $filterTipo = null;
    public function filtrarTipo($tipo)
    {
        $this->resetPage(); // Reiniciar la paginación al filtrar

        // Establece o limpia el filtro de tipo (cliente|empresa)
        if ($tipo === 'todos' || $tipo === null) {
            $this->filterTipo = null;
        } else {
            $this->filterTipo = $tipo;
        }
    }


    // Propiedades públicas que se pueden acceder desde la vista
    public $search = '';
    public $userType;

    public function mount()
    {
        // Asignamos el tipo de usuario a la propiedad pública
        $this->userType = Auth::user()->usuarios
            ? strtolower(Auth::user()->usuarios->tipousuarios->tipousu)
            : '';

        // Cargar los tipos de usuarios para el select del formulario
        $this->tiposUsuario = TipoUsuarios::all();
    }

    /**
     * Método para limpiar el número de página cuando se busca algo nuevo.
     * Livewire lo llama automáticamente cuando la propiedad 'search' cambia.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModalCrear()
    {
        $this->resetValidation();
        $this->reset(['form', 'foto', 'editando', 'usuarioId']);
        $this->modalAbierto = true;
    }
    public function cerrarModal()
    {
        $this->modalAbierto = false;
        $this->reset(['form', 'foto', 'usuarioId', 'editando']);
        $this->resetValidation();
    }
}
