<?php

namespace App\Livewire;

use App\Models\Suscripcion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SuscripcionPlan extends Component
{
    public function seleccionarPlan($plan)
    {
        $usuario = Auth::user();
        $tipo = $usuario->tipoUsuario?->tipousu;

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
                ->where('plan', 'gratis')
                ->latest('fecha_fin')
                ->first();

            if ($ultimaGratis) {
                $fechaFin = $ultimaGratis->fecha_fin?->format('d/m/Y');

                // ⚠️ Mostrar solo una vez en esta sesión
                if (!session()->has('suscripcion.warning.shown')) {
                    session()->flash(
                        'warning',
                        "⚠️ Ya utilizaste tu plan gratuito hasta el {$fechaFin}. 
                        No puedes volver a suscribirte gratis. 
                        Te recomendamos elegir un plan mensual o anual."
                    );
                    session()->put('suscripcion.warning.shown', true);
                }

                return redirect()->route('dashboard');
            }
        }

        // 🔹 Si ya tiene suscripción activa
        if ($usuario->suscripcion && $usuario->suscripcion->activa) {
            return redirect()->route('dashboard');
        }

        // 🔹 Crear nueva suscripción
        $suscripcion = Suscripcion::create([
            'plan' => $plan,
            'fecha_inicio' => now(),
            'fecha_fin' => match ($plan) {
                'gratis' => now()->addMonth(),
                'mensual' => now()->addMonth(),
                'anual' => now()->addYear(),
                default => null,
            },
            'activa' => true,
            'fk_idusuarios' => $usuario->id,
        ]);

        // ✅ Mostrar confirmación solo una vez por sesión
        if (!session()->has('suscripcion.success.shown')) {
            session()->flash('success', "✅ Te has suscrito al plan {$plan}.");
            session()->put('suscripcion.success.shown', true);
        }

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.suscripcion-plan')->layout('layouts.app');
    }
}
