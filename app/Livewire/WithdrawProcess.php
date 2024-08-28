<?php

namespace App\Livewire;

use App\Models\Card;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class WithdrawProcess extends Component
{
    use WithPagination;
    use ConfirmsPasswords;

    // Properties
    public $passwordConfirmed = false;
    public $moneyQty = 0;

    public $otherActive = false;
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

    // Search and Pagination
    protected $updatesQueryString = ['search', 'page'];

    public function updatingMoneyQty()
    {
        $this->selectedCard = null;
        $this->resetPage();
    }

    // Render Component
    public function mount()
    {
        $this->passwordConfirmed = session('passwordConfirmed', false);
    }

    public function render()
    {
        $cards = auth()->user()->cards()
            ->when($this->moneyQty, function ($query, $search) {
                    $query->where('amount', '>=', $search);
            })
            ->orderBy('amount', 'asc')
            ->paginate(3);

        return view('livewire.withdraw-process', ['cards' => $cards]);
    }


    // Actions

    public function confirmPassword()
    {
        $this->passwordConfirmed = true;
        session(['passwordConfirmed' => true]);
    }

    public function setMoneyQty($moneyQty){
        if($this->moneyQty === $moneyQty){
            $this->moneyQty = 0;
            return;
        }
        $this->moneyQty = $moneyQty;
        $this->otherActive = false;
    }
    public function setSelectedCard($card_number){
        if($this->selectedCard?->card_number === $card_number){
            $this->selectedCard = null;
            return;
        }
        $this->selectedCard = Card::where('card_number', $card_number)->firstOrFail();

    }

    public function changeOtherState(){
        $this->moneyQty = 0;
        $this->otherActive = !$this->otherActive;
    }

    // Trigger Events Actions

    public function openWithdrawalModal(){

        $this->businessRules();

        $this->dispatch('updateWithdrawQty', $this->moneyQty);
        $this->dispatch('updateWithdrawCard', $this->selectedCard?->card_number);
        $this->dispatch('openWithdrawModal');
    }

    // Listener Events Actions

    #[On('route-changed')]
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
        $this->reset(['passwordConfirmed', 'moneyQty', 'selectedCard', 'timeLeft']);
        session()->forget('passwordConfirmed');
    }
    #[On('successWithdraw')]
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
        $this->reset(['passwordConfirmed', 'moneyQty', 'selectedCard', 'timeLeft']);
        session()->forget('passwordConfirmed');
    }

    #[On('endWithdrawing')]
    public function endWithdraw()
    {
        $this->dispatch('showTimeOutModal');
        $this->reset(['passwordConfirmed', 'moneyQty', 'selectedCard', 'timeLeft']);
        session()->forget('passwordConfirmed');
    }

    // Rules

    public function businessRules(){

        if ($this->moneyQty <= 0){
            throw ValidationException::withMessages([
                'openModal' => 'Please select a cash amount to proceed',
            ]);
        }
        if (!$this->selectedCard){
            throw ValidationException::withMessages([
                'openModal' => 'Please select your card to proceed',
            ]);
        }
        if($this->moneyQty < 10000){
            throw ValidationException::withMessages([
                'openModal' => 'The amount need to be higher than $10.000',
            ]);
        }
        if($this->moneyQty % 10000 !== 0){
            throw ValidationException::withMessages([
                'openModal' => 'This cash amount is invalid',
            ]);
        }
        if ($this->selectedCard->amount < $this->moneyQty){
            throw ValidationException::withMessages([
                'openModal' => 'This card does not have enough money',
            ]);
        }
    }
}
