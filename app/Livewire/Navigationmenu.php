<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navigationmenu extends Component
{
    public $userType;

    public function mount()
    {
        if (Auth::check() && Auth::user()->tipousuarios) {
            $this->userType = strtolower(Auth::user()->tipousuarios->tipousu);
        } else {
            $this->userType = null;
        }
    }

    public function render()
    {
        return view('livewire.navigationmenu', [
            'userType' => $this->userType,
        ]);
    }
}
