<?php

namespace App\Livewire\Auth;

use App\Models\Empresas;
use App\Models\Personas;
use App\Models\Reprelegal;
use App\Models\TipoUsuarios;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class Register extends Component
{
    use WithFileUploads;

    public $layout = 'layouts.app';

    public string $userType = 'client';
    public $document_type = 'dni';
    public $dni, $nombres, $apellidos, $telefono;
    public $nameempresa, $ruc, $razonsocial, $direccion, $telefono_empresa;

    public $dni_reprelegal;
    public $nombres_reprelegal;
    public $apellidos_reprelegal;

    public $email;
    public $password;
    public $photo = null;
    public $password_confirmation;
    public $estadousuario = '1';
    public $name;

    public function setUserType(string $type): void
    {
        $this->userType = $type;
        $this->resetValidation();
        $this->reset(['dni', 'dni', 'nombres', 'apellidos', 'telefono', 'nameempresa', 'ruc', 'razonsocial', 'direccion', 'telefono_empresa']);
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.app');
    }

    // Método para buscar DNI del cliente o representante legal
    public function buscarDni()
    {
        $this->validate(['dni' => 'required|min:8|max:8|regex:/^[0-9]+$/']);
        $token = config('services.apisnet.token');
        $response = Http::withHeaders(['Authorization' => "Bearer {$token}"])
            ->get('https://api.decolecta.com/v1/reniec/dni', ['numero' => $this->dni]);

        if ($response->successful()) {
            $datadni = $response->json();
            $this->nombres = $datadni['first_name'] ?? '';
            $this->apellidos = $datadni['first_last_name'] . ' ' . ($datadni['second_last_name'] ?? '');
            session()->flash('message', '✅ DNI válido, datos encontrados.');
        } else {
            $this->reset(['nombres', 'apellidos']);
            $this->addError('dni', '❌ No se encontraron datos.');
        }
    }
    // Método para buscar RUC
    public function buscarRUC()
    {
        $this->validate(['ruc' => 'required|min:11|max:11|regex:/^[0-9]+$/']);
        $token = config('services.apisnet.token');
        $response = Http::withHeaders(['Authorization' => "Bearer {$token}"])
            ->get('https://api.decolecta.com/v1/sunat/ruc', ['numero' => $this->ruc]);

        if ($response->successful()) {
            $dataruc = $response->json();
            $this->nameempresa = $dataruc['razon_social'] ?? '';
            $this->razonsocial = $dataruc['razon_social'] ?? '';
            $this->direccion = $dataruc['direccion'] ?? '';
            $this->dispatch('mostrar-notificacion_ruc', [
                'message' => '✅ RUC válido, datos encontrados.',
                'type' => 'success',
            ]);
            // Dispara el evento para hacer foco
            $this->dispatch('hacer-foco', [
                'element' => 'telefono_empresa',
            ]);
        } else {
            $this->reset(['nameempresa', 'razonsocial', 'direccion']);
            $this->addError('ruc', '❌ No se encontraron datos.');
        }
    }



    // METODO PRINCIPAL DE REGISTRO
    public function register()
    {
        \Log::info('Inicio del método register con userType: ' . $this->userType);
        try {
            // Validación base
            $rules = [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];

            // Reglas según tipo de usuario
            if ($this->userType === 'client') {
                $rules = array_merge($rules, [
                    'dni' => ['required', 'string', 'max:8', 'unique:personas,dni'],
                    'nombres' => ['required', 'string', 'max:255'],
                    'apellidos' => ['required', 'string', 'max:255'],
                    'telefono' => ['nullable', 'string', 'max:9'],
                ]);
            } elseif ($this->userType === 'company') {
                $rules = array_merge($rules, [
                    'nameempresa' => ['required', 'string', 'max:255'],
                    'ruc' => ['required', 'string', 'max:11', 'unique:empresas,ruc'],
                    'razonsocial' => ['required', 'string', 'max:255'],
                    'direccion' => ['nullable', 'string'],
                    'telefono_empresa' => ['nullable', 'string'],
                    'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                    'dni' => ['required', 'string', 'max:8', 'unique:personas,dni'],
                    'nombres' => ['required', 'string', 'max:255'],
                    'apellidos' => ['required', 'string', 'max:255'],
                    'telefono' => ['nullable', 'string', 'max:9'],
                ]);
            }

            \Log::info('>>> Validando datos...');
            $this->validate($rules);
            \Log::info('>>> Validación exitosa');

            if ($this->userType === 'client') {
                // Crear persona
                $persona = Personas::create([
                    'dni' => $this->dni,
                    'nombres' => $this->nombres,
                    'apellidos' => $this->apellidos,
                    'celular' => $this->telefono,
                ]);

                \Log::info('Persona cliente creada con ID: ' . $persona->id);
                // Crear usuario con rol cliente
                $rol = 'Cliente';
                $tipoUsuario = TipoUsuarios::firstOrCreate(['tipousu' => $rol], ['tipousu' => $rol]);
                \Log::info("Rol '{$rol}' id = {$tipoUsuario->id}");

                $this->createUser($this->nombres.''.$this->apellidos, $this->email, $this->password, $this->photo, $persona->id, $tipoUsuario->id, $this->estadousuario);
                \Log::info('Usuario cliente creado con email: ' . $this->email);

            } elseif ($this->userType === 'company') {
                // Crear persona representante legal
                $persona = Personas::create([
                    'dni' => $this->dni,
                    'nombres' => $this->nombres,
                    'apellidos' => $this->apellidos,
                    'celular' => $this->telefono_empresa, // Usar el teléfono del representante
                ]);
                // Crear empresa
                $empresa = Empresas::create([
                    'nameempresa' => $this->nameempresa,
                    'razonsocial' => $this->razonsocial,
                    'ruc' => $this->ruc,
                    'direccion' => $this->direccion,
                    'telefono' => $this->telefono_empresa,
                ]);
                \Log::info('Empresa creada con ID: ' . $empresa->id);
                // Relación representante legal
                $repre_legal = Reprelegal::create([
                    'fecha' => now(),
                    'fk_idempresas' => $empresa->id,
                    'fk_idpersonas' => $persona->id,
                ]);
                \Log::info('Persona representante legal creada con ID: ' . $repre_legal->id);

                // Crear usuario con rol empresa
                $rol = 'Empresa';
                $tipoUsuario = TipoUsuarios::firstOrCreate(['tipousu' => $rol], ['tipousu' => $rol]);

                $this->createUser($this->nameempresa, $this->email, $this->password, $this->photo, $persona->id, $tipoUsuario->id, $this->estadousuario);
                \Log::info('Usuario empresa creado con email: ' . $this->email);
            }

            // Intentar login automático
            if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
                session()->regenerate();
                return redirect()->intended('/dashboard')->with('success', '¡Registro completado exitosamente!');
            }

            session()->flash('error', 'Error al iniciar sesión automáticamente. Por favor, inicia sesión manualmente.');
            return redirect()->route('login');
        } catch (ValidationException $e) {
            \Log::error('❌ Error de validación en register(): ' . $e->getMessage(), [
                'errors' => $e->errors()
            ]);
            throw $e; // Relanzar para que Livewire muestre los errores en la vista
        } catch (\Throwable $e) {
            \Log::error('❌ Error en register(): ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }

    // Crear usuario en la tabla usuarios
    protected function createUser($name, $email, $password, $phtoto, $personaId = null, $tipoUsuarioId = null, $estadousuario)
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'profile_photo_path' => $phtoto,
            'fk_idpersonas' => $personaId,
            'fk_idtipousuarios' => $tipoUsuarioId,
            'estado_usu' => $estadousuario,
        ]);
    }
}
