<?php

namespace App\Livewire;

use App\Models\Suscripcion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Personas;
use App\Models\RepreLegal;
use App\Models\Empresas;

class SuscripcionPlan extends Component
{
    public $registro;
    public $registro_type;
    public $pendingPlan = null;
    public $showPayment = false;
    public $payment_method = null;

    public function mount()
    {
        $this->cargarRegistro();
    }
    public function seleccionarPlan($plan)
    {
        $usuario = Auth::user();
        $tipo = $usuario->tipoUsuario?->tipousu;

        // Cargar el registro asociado al usuario antes de procesar
        $this->cargarRegistro();

        if ($tipo === 'Cliente') {
            return redirect()->route('dashboard');
        }

        // 🔹 Marcar como inactiva si ya expiró (al entrar al flujo)
        if ($usuario->suscripcion && $usuario->suscripcion->fecha_fin && now()->greaterThan($usuario->suscripcion->fecha_fin)) {
            $usuario->suscripcion->update(['activa' => false]);
        }

        // 🔹 Validar si ya tuvo plan gratis
        if ($plan === 'gratis') {
            $ultimaGratis = Suscripcion::where('fk_idusuarios', $usuario->id)
                ->where('tipo_suscripcion', 'gratis')
                ->latest('fecha_fin')
                ->first();

            if ($ultimaGratis) {
                $fechaFin = $ultimaGratis->fecha_fin?->format('d/m/Y');

                // Mostrar aviso y permanecer en el panel (no redirigir)
                session()->flash(
                    'warning',
                    "⚠️ Ya utilizaste tu plan gratuito hasta el {$fechaFin}. Para continuar debes elegir un plan pago."
                );

                return; // permanecer en el modal/panel
            }

            // Crear suscripción gratuita inmediata por 1 mes
            $suscripcion = Suscripcion::create([
                'tipo_suscripcion' => 'gratis',
                'fecha_inicio' => now(),
                'fecha_fin' => now()->addMonth(),
                'estado' => true,
                'fk_idusuarios' => $usuario->id,
            ]);

            session()->flash('success', "✅ Te has suscrito al plan gratuito por 1 mes.");
            return redirect()->route('dashboard');
        }

        // 🔹 Si ya tiene suscripción activa
        if ($usuario->suscripcion && $usuario->suscripcion->activa) {
            session()->flash('info', 'Ya tienes una suscripción activa.');
            return;
        }

        // Para planes de pago: iniciar flujo de pago (Yape / transferencia / otro)
        if (in_array($plan, ['mensual', 'anual'])) {
            $this->iniciarPago($plan);
            return;
        }
    }

    public function iniciarPago($plan)
    {
        $this->pendingPlan = $plan;
        $this->showPayment = true;
    }

    public function procesarPago($metodo)
    {
        $usuario = Auth::user();

        if (! $this->pendingPlan) {
            session()->flash('error', 'No hay un plan pendiente.');
            return;
        }

        // Aquí se integraría la pasarela de pago real.
        // Por ahora simulamos pago exitoso y creamos la suscripción.
        $plan = $this->pendingPlan;

        $suscripcion = Suscripcion::create([
            'tipo_suscripcion' => $plan,
            'fecha_inicio' => now(),
            'fecha_fin' => match ($plan) {
                'mensual' => now()->addMonth(),
                'anual' => now()->addYear(),
                default => now()->addMonth(),
            },
            'estado' => true,
            'fk_idusuarios' => $usuario->id,
        ]);

        // Guardar método en sesión como referencia temporal
        session()->flash('success', "Pago procesado por {$metodo}. Suscripción {$plan} activada.");

        // Limpiar estado y redirigir
        $this->pendingPlan = null;
        $this->showPayment = false;

        return redirect()->route('dashboard');
    }

    /**
     * Cargar datos del registro del usuario.
     * - Si la persona es representante legal de una empresa, carga datos de la empresa.
     * - Si no, carga los datos de la persona.
     */
    public function cargarRegistro()
    {
        $usuario = Auth::user();

        $this->registro = null;
        $this->registro_type = null;

        // Intentar obtener la persona asociada al usuario
        $persona = $usuario->personas ?? null;

        if ($persona) {
            // Buscar si esta persona es representante legal de alguna empresa
            $repre = RepreLegal::where('fk_idpersonas', $persona->id)->first();
            if ($repre) {
                $empresa = Empresas::find($repre->fk_idempresas);
                if ($empresa) {
                    $this->registro_type = 'empresa';
                    $this->registro = [
                        'razonsocial' => $empresa->razonsocial,
                        'ruc' => $empresa->ruc,
                        'direccion' => $empresa->direccion,
                        'telefono' => $empresa->telefono,
                    ];
                    return;
                }
            }

            // Si no es representante legal, devolver datos persona
            $this->registro_type = 'persona';
            $this->registro = [
                'dni' => $persona->dni,
                'nombres' => $persona->nombres,
                'apellidos' => $persona->apellidos,
                'celular' => $persona->celular,
            ];
        }
    }

    public function render()
    {
        return view('livewire.suscripcion-plan')->layout('layouts.app');
    }
}
