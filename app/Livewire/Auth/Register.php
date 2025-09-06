<?php

namespace App\Livewire\Auth;

use App\Models\Empresas;
use App\Models\Personas;
use App\Models\Reprelegal;
use App\Models\TipoUsuarios;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Register extends Component
{
    use WithFileUploads;

    public $layout = 'layouts.app';

    public string $userType = 'client';
    public $document_type = 'dni';
    public $dni;
    public $nombres;
    public $apellidos;
    public $telefono;
    public $nameempresa;
    public $ruc;
    public $razonsocial;
    public $direccion;
    public $telefono_empresa;
    public $logo_empresa;

    public $dni_reprelegal;
    public $nombres_reprelegal;
    public $apellidos_reprelegal;

    public $email;
    public $password;
    public $password_confirmation;

    public function setUserType(string $type): void
    {
        $this->userType = $type;
        $this->resetValidation();
        $this->reset(['dni', 'dni', 'nombres', 'apellidos', 'telefono', 'nameempresa', 'ruc', 'razonsocial', 'direccion', 'telefono_empresa', 'logo_empresa', 'dni_reprelegal', 'nombres_reprelegal', 'apellidos_reprelegal']);
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
            session()->flash('message', '✅ RUC válido, datos encontrados.');
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
                'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'],
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
                    'ruc' => ['required', 'string', 'max:11', 'unique:empresas,ruc'],
                    'razonsocial' => ['required', 'string', 'max:255'],
                    'direccion' => ['nullable', 'string'],
                    'telefono_empresa' => ['nullable', 'string'],
                    'logo_empresa' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                    'dni' => ['required', 'string', 'max:8', 'unique:personas,dni'],
                    'nombres' => ['required', 'string', 'max:255'],
                    'apellidos' => ['required', 'string', 'max:255'],
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

                $this->createUser($this->email, $this->password, $persona->id, null, $tipoUsuario->id);
                \Log::info('Usuario cliente creado con email: ' . $this->email);
            } elseif ($this->userType === 'company') {
                // Guardar logo (si existe)
                $logoPath = $this->logo_empresa ? $this->logo_empresa->store('logos', 'public') : null;

                // Crear empresa
                $empresa = Empresas::create([
                    'razonsocial' => $this->razonsocial,
                    'ruc' => $this->ruc,
                    'direccion' => $this->direccion,
                    'telefono' => $this->telefono_empresa,
                    'logo' => $logoPath,
                ]);
                \Log::info('Empresa creada con ID: ' . $empresa->id);

                // Crear representante legal
                $persona_repre = Personas::create([
                    'dni' => $this->dni,
                    'nombres' => $this->nombres,
                    'apellidos' => $this->apellidos,
                ]);
                \Log::info('Persona representante legal creada con ID: ' . $persona_repre->id);

                // Relación representante legal
                Reprelegal::create([
                    'fecha' => now(),
                    'fk_idempresas' => $empresa->id,
                    'fk_idpersonas' => $persona_repre->id,
                ]);

                // Crear usuario con rol empresa
                $tipoUsuario = TipoUsuarios::where('tipousu', 'empresa')->first();
                $this->createUser($this->email, $this->password, $persona_repre->id, $empresa->id, $tipoUsuario->id);
            }

            // Intentar login automático
            if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
                session()->regenerate();
                return redirect()->intended('/login')->with('success', '¡Registro completado exitosamente!');
            }

            session()->flash('error', 'Error al iniciar sesión automáticamente. Por favor, inicia sesión manualmente.');
            return redirect()->route('login');
        } catch (\Throwable $e) {
            \Log::error('❌ Error en register(): ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }

    // Crear usuario en la tabla usuarios
    protected function createUser($email, $password, $personaId = null, $empresaId = null, $tipoUsuarioId = null)
    {
        return Usuarios::create([
            'email' => $email,
            'password' => Hash::make($password),
            'fk_idpersonas' => $personaId,
            'fk_idempresas' => $empresaId,
            'fk_idtipousuarios' => $tipoUsuarioId,
        ]);
    }
}