<?php

namespace App\Livewire;

use App\Models\Card;
use Illuminate\Validation\ValidationException;
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
    public $timeLeft = 0;

    public $success = false;

    public $data = [
        'cardNumber' => 0,
        'cardType' => '',
        'quantity' => 0,
        'amount' => 0,
        'denominationsCounts' => null,
    ];

    protected $listeners = [
        'endWithdrawing' => 'endWithdraw',
        'resetTimeOut' => 'resetTimer',
        'successWithdraw' => 'success',
        'routeChanged' => 'resetComponent'
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
    }


    // Events

    public function endWithdraw()
    {
        $this->dispatch('showTimeOutModal');
        $this->reset(['passwordConfirmed', 'moneyQty', 'selectedCard', 'timeLeft']);
        session()->forget('passwordConfirmed');
    }

    public function setMoneyQty($moneyQty){
        if($this->moneyQty === $moneyQty){
            $this->moneyQty = 0;
            return;
        }
        $this->moneyQty = $moneyQty;
        $this->dispatch('updateWithdrawQty', $moneyQty);
    }
    public function setSelectedCard($card_number){
        if($this->selectedCard?->card_number === $card_number){
            $this->selectedCard = null;
            return;
        }
        $this->selectedCard = Card::where('card_number', $card_number)->firstOrFail();
        $cardNumber = $this->selectedCard->card_number;
        $this->dispatch('updateWithdrawCard', $cardNumber);

    }

    public function openWithdrawalModal(){
        if($this->selectedCard && $this->moneyQty != 0){
            $this->dispatch('openWithdrawModal');
        }else if (!$this->selectedCard){
            throw ValidationException::withMessages([
                'openModal' => 'Please select your card to proceed',
            ]);
        }else{
            throw ValidationException::withMessages([
                'openModal' => 'Please select a cash amount to proceed',
            ]);
        }
    }
    public function resetComponent()
    {
        $this->reset([
            'passwordConfirmed',
            'moneyQty',
            'selectedCard',
            'timeLeft',
            'success',
            'data'
        ]);
        $this->passwordConfirmed = false;
        $this->success = false;
        session()->forget('passwordConfirmed');
    }
    public function success($data){
        $this->reset([
            'passwordConfirmed',
            'moneyQty',
            'selectedCard',
            'timeLeft',
            'success',
            'data'
        ]);
        $this->passwordConfirmed = false;
        $this->success = true;
        $this->data = $data;
    }
}
