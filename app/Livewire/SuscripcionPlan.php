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

        // Si ya tiene una suscripción activa, redirigir
        if ($usuario->suscripcion && $usuario->suscripcion->activa) {
            return redirect()->route('dashboard');
        }

        // Crear suscripción según el plan
        $suscripcion = Suscripcion::create([
            'usuario_id' => $usuario->id,
            'plan' => $plan,
            'fecha_inicio' => now(),
            'fecha_fin' => $plan === 'gratis' ? now()->addMonth() : now()->addYear(),
            'activa' => true,
        ]);

        session()->flash('success', "Te has suscrito al plan {$plan}.");
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.suscripcion-plan')->layout('layouts.app');
    }
}