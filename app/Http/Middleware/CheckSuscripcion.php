<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckSuscripcion
{
    public function handle($request, Closure $next)
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        $tipo = $usuario->tipousuarios?->tipousu;

        Log::info("Middleware CheckSuscripcion - Usuario {$usuario->id}, tipo: {$tipo}");

        // Clientes y SuperAdmin → no necesitan suscripción
        if ($tipo === 'Cliente' || $tipo === 'SuperAdmin') {
            return $next($request);
        }

        // Empresas
        if ($tipo === 'Empresa') {
            $suscripcion = $usuario->suscripcion;

            // Si no tiene suscripción → mandar a elegir plan
            if (!$suscripcion) {
                return redirect()->route('suscripcion.plan');
            }

            // Si la suscripción expiró
            if ($suscripcion->fecha_fin && now()->greaterThan($suscripcion->fecha_fin)) {
                $suscripcion->update(['activa' => false]);

                // Guardamos un mensaje temporal
                session()->flash('warning', "Tu suscripción ha expirado. Elige un plan mensual o anual para continuar disfrutiendo de todas las funcionalidades.");

                // Si no estamos ya en la ruta de selección de plan, redirigimos al panel de suscripción.
                if (! $request->routeIs('suscripcion.plan')) {
                    return redirect()->route('suscripcion.plan');
                }
            }
        }

        return $next($request);
    }
}
