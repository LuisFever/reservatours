<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\Suscripcion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SeleccionarPlan extends Component
{
    public function seleccionar($planId)
    {
        $plan = Plan::findOrFail($planId);

        Suscripcion::create([
            'usuario_id' => Auth::id(),
            'plan_id' => $plan->id,
            'fecha_inicio' => now(),
            'fecha_fin' => $plan->duracion_dias ? now()->addDays($plan->duracion_dias) : null,
            'activa' => true,
        ]);

        return redirect()->route('home')->with('success', 'Plan seleccionado exitosamente.');
    }

    public function render()
    {
        return view('livewire.seleccionar-plan', [
            'planes' => Plan::all()
        ]);
    }
}
