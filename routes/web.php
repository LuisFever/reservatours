<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Inicio;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\SuscripcionPlan;
use App\Http\Controllers\EmailVerificationController;

// Página de inicio
Route::get('/', Inicio::class)->name('inicio');

// Login y Registro (Livewire)
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

// Email verification
Route::post('/email/send-code', [EmailVerificationController::class, 'sendCode']);
Route::post('/email/validate-code', [EmailVerificationController::class, 'validateCode']);

// Página donde el usuario elige plan (solo si ya está autenticado)
Route::middleware(['auth'])->get('/suscripcion', SuscripcionPlan::class)->name('suscripcion.plan');

// Grupo de rutas protegidas por auth
Route::middleware(['auth', 'suscripcion'])->group(function () {

    // Ruta genérica /dashboard que redirige según el tipo
    Route::get('/dashboard', function () {
        $user = auth()->user();
        // intenta obtener tipo desde relación tipousuarios (o desde session si la tienes)
        $tipo = $user->tipoUsuario?->tipousu ?? session('user_type') ?? null;
        $tipoLower = is_string($tipo) ? strtolower($tipo) : null;

        return match ($tipoLower) {
            'empresa' => redirect()->route('dashboard.empresa'),
            'cliente' => redirect()->route('dashboard.cliente'),
            default => view('dashboard') // fallback si no hay tipo
        };
    })->name('dashboard');

    // Dashboard cliente
    Route::get('/dashboard/cliente', function () {
        // la vista dashboard.cliente debe contener/extend tu layout y mostrar contenido del cliente
        return view('dashboard.cliente');
    })->name('dashboard.cliente');

    // Dashboard empresa
    Route::get('/dashboard/empresa', function () {
        return view('dashboard.empresa');
    })->name('dashboard.empresa');

    // Panel extra de empresa (ejemplo)
    Route::get('/empresa/panel', function () {
        return view('empresa.panel');
    })->name('empresa.panel');

});
