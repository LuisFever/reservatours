<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Register extends Component
{
    // Opcion para manejar el tipo de usuario (cliente o empresa)
    public string $userType = 'client'; // 'client' por defecto
    public function setUserType(string $type): void
    {
        $this->userType = $type;
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.app');
    }

    // API - RENIEC y SUNAT
    // DNI
    public $dni;
    public $nombres;
    public $apellidos;
    public function buscarDni()
    {
        $token = config('services.apisnet.token'); // tu token en config/services.php
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->get('https://api.decolecta.com/v1/reniec/dni', [
            'numero' => $this->dni
        ]);

        if ($response->successful()) {
            $datadni = $response->json();
            // 👇 CON DNI
            $this->nombres   = $datadni['first_name']   ?? '';
            $this->apellidos = $datadni['first_last_name'] . ' ' . ($datadni['second_last_name'] ?? '');
            session()->flash('message', '✅ DNI válido, datos encontrados.');
        } else {
            $this->reset(['nombres', 'apellidos']); // limpia campos
            $this->addError('dni', '❌ No se encontró datos.');
        }
    }

    //RUC
    public $nameempresa;
    public $ruc;
    public $razonsocial;
    public $direccion;
    public function buscarRUC()
    {
        $token = config('services.apisnet.token'); // tu token en config/services.php
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->get('https://api.decolecta.com/v1/sunat/ruc', [
            'numero' => $this->ruc
        ]);

        if ($response->successful()) {
            $dataruc = $response->json();
            // 👇 CON RUC
            $this->nameempresa = $dataruc['razon_social'] ?? '';
            $this->ruc = $dataruc['numero_documento'] ?? '';
            $this->razonsocial = $dataruc['razon_social'] ?? '';
            $this->direccion = $dataruc['direccion'] ?? '';
            session()->flash('message', '✅ RUC válido, datos encontrados.');
        } else {
            $this->reset(['nameempresa', 'ruc', 'razonsocial', 'direccion']); // limpia campos
            $this->addError('ruc', '❌ No se encontró datos.');
        }

    }
    
}
