<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Inicio;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\SuscripcionPlan;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Livewire\Dashboard;
use App\Livewire\admin\VistaUsuarios;


// Página de inicio - Los $slot cargan aqui primero por el '/'
Route::get('/', Inicio::class)->name('inicio');

// Login y Registro (Livewire)
Route::get('/login', Login::class)->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/register', Register::class)->name('register');

// Email verification
Route::post('/email/send-code', [EmailVerificationController::class, 'sendCode']);
Route::post('/email/validate-code', [EmailVerificationController::class, 'validateCode']);

// Página donde el usuario elige plan (solo si ya está autenticado)
Route::middleware(['auth'])->get('/suscripcion', SuscripcionPlan::class)->name('suscripcion.plan');

// Grupo de rutas protegidas por auth
Route::middleware(['auth', 'suscripcion'])->group(function () {

    // Ruta genérica /dashboard: usar directamente el componente Livewire
    // (Se usa el componente Livewire `Dashboard` más abajo)

    // Rutas específicas por tipo de dashboard (cliente/empresa) fueron removidas
    // Se usa la ruta genérica '/dashboard' que carga el componente Livewire `Dashboard`

    //Para el dashboard de usuario
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/admin/vistausuarios', VistaUsuarios::class)->name('admin.vistausuarios');



});
