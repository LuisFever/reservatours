<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;
use Carbon\Carbon;

class LoginController extends Controller
{
    const MAX_ATTEMPTS = 5;        // Máximo de intentos fallidos
    const LOCKOUT_TIME = 15;       // Tiempo de bloqueo en minutos

    public function store(LoginRequest $request): RedirectResponse
    {
        // Obtener credenciales
        $email = $request->input('email');
        $password = $request->input('password');
        
        // Verificar si el usuario existe
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        // Verificar si el usuario está activo
        if (!$user->estado_usu) {
            return back()->withErrors([
                'email' => 'Tu cuenta está inactiva. Contacta al administrador.',
            ])->onlyInput('email');
        }

        // Verificar si el usuario está bloqueado por intentos fallidos
        if ($this->isUserBlocked($user)) {
            $remainingTime = $this->getRemainingBlockTime($user);
            return back()->withErrors([
                'email' => "Cuenta bloqueada por múltiples intentos fallidos. Intenta nuevamente en {$remainingTime} minutos.",
            ])->onlyInput('email');
        }

        // Intentar autenticación
        if (!Hash::check($password, $user->password)) {
            $this->recordFailedAttempt($user);
            
            $remainingAttempts = self::MAX_ATTEMPTS - ($user->intentos_fallidos ?? 0);
            
            if ($remainingAttempts <= 0) {
                return back()->withErrors([
                    'email' => 'Cuenta bloqueada por múltiples intentos fallidos.',
                ])->onlyInput('email');
            }
            
            return back()->withErrors([
                'email' => "Contraseña incorrecta. Te quedan {$remainingAttempts} intentos.",
            ])->onlyInput('email');
        }

        // Login exitoso - limpiar intentos fallidos
        $this->clearFailedAttempts($user);
        
        // Autenticar usuario
        Auth::login($user);
        $request->session()->regenerate();
        
        // Redireccionar según el tipo de usuario (fk_idtipousuarios)
        return $this->redirectUserByType($user->fk_idtipousuarios);
    }

    private function isUserBlocked(User $user): bool
    {
        if (!$user->bloqueado_hasta) {
            return false;
        }
        
        $blockedUntil = Carbon::parse($user->bloqueado_hasta);
        
        // Si el bloqueo ya expiró, desbloquear automáticamente
        if ($blockedUntil->isPast()) {
            $user->update([
                'bloqueado_hasta' => null,
                'intentos_fallidos' => 0
            ]);
            return false;
        }
        
        return true;
    }

    private function getRemainingBlockTime(User $user): int
    {
        if (!$user->bloqueado_hasta) {
            return 0;
        }
        
        $now = Carbon::now();
        $blockedUntil = Carbon::parse($user->bloqueado_hasta);
        
        return $now->diffInMinutes($blockedUntil, false);
    }

    private function recordFailedAttempt(User $user): void
    {
        $intentos = ($user->intentos_fallidos ?? 0) + 1;
        
        $updateData = ['intentos_fallidos' => $intentos];
        
        // Si alcanza el máximo de intentos, bloquear usuario
        if ($intentos >= self::MAX_ATTEMPTS) {
            $updateData['bloqueado_hasta'] = Carbon::now()->addMinutes(self::LOCKOUT_TIME);
        }
        
        $user->update($updateData);
    }

    /**
     * Limpiar intentos fallidos
     */
    private function clearFailedAttempts(User $user): void
    {
        $user->update([
            'intentos_fallidos' => 0,
            'bloqueado_hasta' => null,
            'ultimo_acceso' => Carbon::now()
        ]);
    }

    private function redirectUserByType($userTypeId): RedirectResponse
    {
        // Redirigir basado en el ID del tipo de usuario
        // Los tipos suelen ser: 1 = superadmin, 2 = cliente, 3 = empresa
        switch ((int)$userTypeId) {
            case 1:
                // SuperAdmin
                return redirect()->route('dashboard');
            case 2:
                // Cliente
                return redirect()->route('dashboard');
            case 3:
                // Empresa
                return redirect()->route('dashboard');
            default:
                return redirect()->route('dashboard');
        }
    }

    protected function authenticated(Request $request, $user)
    {
        // Guardamos el tipo de usuario en sesión si es necesario
        if ($user->tipousuarios) {
            session(['user_type' => strtolower($user->tipousuarios->tipousu)]);
        }
    }
}
