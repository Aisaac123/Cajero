<?php

namespace App\Livewire;

use App\Models\Card;
use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Component;
use Livewire\WithPagination;

class WithdrawProcess extends Component
{
    use WithPagination;
    use ConfirmsPasswords;

    public $passwordConfirmed = false;
    public $moneyQty = 0;
    public ?Card $selectedCard = null;
    public $timeoutId;

    protected $listeners = [
        'endWithdrawing' => 'endWithdraw',
    ];

    public function mount()
    {
        $this->passwordConfirmed = session('passwordConfirmed', false);
    }

    public function render()
    {
        return view('livewire.withdraw-process');
    }

    public function confirmed()
    {
        $this->passwordConfirmed = true;
        session(['passwordConfirmed' => true]);
        $this->startWithdrawingTimeout();
    }

    public function startWithdrawingTimeout()
    {
        $this->timeoutId = now()->addMinutes(5);
        $this->dispatch('refreshComponent');
    }

    public function getTimeLeftProperty()
    {
        if (!$this->timeoutId) {
            return null;
        }
        return max(0, $this->timeoutId->diffInSeconds(now()));
    }

    public function endWithdraw()
    {
        $this->dispatch('showTimeOutModal');
        $this->reset(['passwordConfirmed', 'moneyQty', 'selectedCard', 'timeoutId']);
        session()->forget('passwordConfirmed');
    }

    public function setMoneyQty($moneyQty){
        if($this->moneyQty === $moneyQty){
            $this->moneyQty = null;
            return;
        }
        $this->moneyQty = $moneyQty;
    }
    public function setSelectedCard($card_number){
        if($this->selectedCard?->card_number === $card_number){
            $this->selectedCard = null;
            return;
        }
        $this->selectedCard = Card::where('card_number', $card_number)->firstOrFail();
    }
}
