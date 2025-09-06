<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSuscripcion
{
    public function handle($request, Closure $next)
    {
        $usuario = Auth::user();

        if (!$usuario->suscripcion || !$usuario->suscripcion->activa) {
            return redirect()->route('suscripcion.plan');
        }

        return $next($request);
    }
}