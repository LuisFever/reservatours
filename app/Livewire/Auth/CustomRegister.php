<?php

namespace App\Livewire\Auth;
use App\Actions\Fortify\CreateNewUser;

use Livewire\Component;

class CustomRegister extends Component
{
    protected $creator;
    public function _construct(CreateNewUser $creator)
    {
        $this->creator = $creator;
    }



}
