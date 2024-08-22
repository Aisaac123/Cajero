<?php

namespace App\Livewire;

use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Component;

class WithdrawProcess extends Component
{
    use ConfirmsPasswords;
    public $passwordConfirmed = false;

    public $moneyQty = 0;

    public function mount()
    {
        $this->passwordConfirmed = session('passwordConfirmed', false);
    }

    public function render()
    {
        $this->passwordConfirmed = session('passwordConfirmed', false);
        return view('livewire.withdraw-process');
    }
    public function confirmed(){
        $this->passwordConfirmed = true;
        session(['passwordConfirmed' => true]);
    }

    public function setMoneyQty($moneyQty){
        $this->moneyQty = $moneyQty;
    }
}
