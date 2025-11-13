<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function store(LoginRequest $request): RedirectResponse
    {
        // Obtener credenciales
        $email = $request->input('email');
        $password = $request->input('password');

        // Verificar si el usuario existe
        $user = Usuarios::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'El correo electrónico no está registrado.']);
        }

        // Intentar autenticar al usuario
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return back()->withErrors(['password' => 'La contraseña es incorrecta.']);
        }

        // Obtener el tipo de usuario desde la relación
        $userType = $user->tipousuarios->tipousu ?? 'unknown';

        // Guardar el tipo de usuario en la sesión
        session(['user_type' => $userType]);

        // Redireccionar según el tipo de usuario
        return $this->redirectUserByType($userType);
    }

    private function redirectUserByType(string $userType): RedirectResponse
    {
        switch ($userType) {
            case 'cliente':
                return redirect()->route('dashboard.cliente');
            case 'empresa':
                return redirect()->route('dashboard.empresa');
            case 'admin':
                return redirect()->route('dashboard');
            default:
                return redirect()->route('dashboard');
        }
    }

    protected function authenticated(Request $request, $user)
    {
        // 👇 Guardamos el tipo de usuario en sesión
        session([
            'user_type' => $user->tipo_usuario,  // cliente / empresa
            'user_name' => $user->name,
        ]);

        // Redirigimos según el tipo de usuario
        if ($user->tipo_usuario === 'cliente') {
            return redirect()->route('dashboard.cliente');
        } elseif ($user->tipo_usuario === 'empresa') {
            return redirect()->route('dashboard.empresa');
        }

        return redirect()->route('dashboard'); // fallback
    }
}
