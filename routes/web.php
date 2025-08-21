<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Inicio;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Layouts\app;
use App\Http\Controllers\EmailVerificationController;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Mail;

Route::get('/', Inicio::class)->name('inicio'); 

// Login y Registro personalizados
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::post('/email/send-code', [EmailVerificationController::class, 'sendCode']);
Route::post('/email/validate-code', [EmailVerificationController::class, 'validateCode']);
