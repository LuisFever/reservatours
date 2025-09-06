<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Inicio;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\SuscripcionPlan; // 👈 crea este componente con "php artisan make:livewire SuscripcionPlan"
use App\Http\Controllers\EmailVerificationController;

// Página de inicio
Route::get('/', Inicio::class)->name('inicio');

// Login y Registro personalizados
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

// Email verification
Route::post('/email/send-code', [EmailVerificationController::class, 'sendCode']);
Route::post('/email/validate-code', [EmailVerificationController::class, 'validateCode']);

// Página donde el usuario elige plan (solo si ya está autenticado)
Route::middleware(['auth'])->get('/suscripcion', SuscripcionPlan::class)->name('suscripcion.plan');

// Grupo de rutas protegidas por auth + suscripción activa
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'suscripcion', // 👈 nuestro middleware nuevo
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 👉 aquí adentro van todas las demás rutas privadas
});
