<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Carbon\Carbon;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        // Personalizar lógica de autenticación
        Fortify::authenticateUsing(function (Request $request) {
            $email = $request->input('email');
            $password = $request->input('password');
            
            // Verificar si el usuario existe
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                return null; // Fortify manejará el error
            }

            // Verificar si el usuario está activo
            if (!$user->estado_usu) {
                return null;
            }

            // Verificar si el usuario está bloqueado
            if ($user->bloqueado_hasta && Carbon::parse($user->bloqueado_hasta)->isFuture()) {
                return null;
            }

            // Verificar contraseña
            if (!Hash::check($password, $user->password)) {
                // Incrementar intentos fallidos
                $intentos = ($user->intentos_fallidos ?? 0) + 1;
                $updateData = ['intentos_fallidos' => $intentos];
                
                if ($intentos >= 5) {
                    $updateData['bloqueado_hasta'] = Carbon::now()->addMinutes(15);
                }
                
                $user->update($updateData);
                return null;
            }

            // Login exitoso - actualizar último acceso y limpiar intentos
            $user->update([
                'intentos_fallidos' => 0,
                'bloqueado_hasta' => null,
                'ultimo_acceso' => Carbon::now()
            ]);

            return $user;
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}

