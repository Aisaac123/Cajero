<?php

namespace App\Livewire\Modals;

use App\Models\Card;
use App\Services\WithdrawService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Mockery\Exception;

class WithdrawModal extends Component
{
    public ?Card $card;
    public $pin;
    public $moneyQty = 0;
    public $showModal = false;

    public $failAttempts = 0;

    public $maxFailAttempts = 3;

    protected $rules = [
        'pin' => 'required|digits:4',
    ];

    protected $listeners = ['openWithdrawModal' => 'openModal',
        'updateWithdrawQty' => 'updateMoneyQty',
        'updateWithdrawCard' => 'updateCard'];

    public function mount(?Card $card)
    {
        if ($card){
            $this->card = $card;
        }
    }
    public function updateMoneyQty($moneyQty)
    {
        if ($moneyQty){
            $this->moneyQty = $moneyQty;
        }
    }
    public function updateCard(int $cardNumber = null){
        if ($cardNumber){
            $cardNumberFormat = $cardNumber;
            if (strlen($cardNumber) == 10){
                $cardNumberFormat = '0' . $cardNumber;
            }
            $this->card = Card::where('card_number', $cardNumberFormat)->firstOrFail();
        }
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function withdraw()
    {
        $this->validate();
        $this->busisnessRules();

        try {
            $this->card->amount -= $this->moneyQty;
            $this->card->save();
            $data = [
                'cardNumber' => $this->card->card_number,
                'cardType' => $this->card->type,
                'quantity' => $this->moneyQty,
                'amount' => $this->card->amount,
                'denominationsCounts' => !str_starts_with($this->card->card_number, '0')  ?
                    WithdrawService::calculateDenominations($this->moneyQty) : null
            ];
            $this->closeModal();
            $this->dispatch('successWithdraw', $data);
            $this->dispatch('resetTimeOut');
        }catch (Exception $e){
            throw $e;
        }
    }

    protected function validateBlockCard(): int {
        if ($this->failAttempts >= $this->maxFailAttempts) {
            $this->card->is_blocked = true;
            $this->card->save();
            session()->flash('card_blocked', 'Your card has been blocked for security reasons.');
            $this->redirectRoute('withdraw.index');
        } else {
            $this->failAttempts++;
        }
        return $this->maxFailAttempts + 1 - $this->failAttempts;
    }

    public function busisnessRules(){
        if (!Hash::check($this->pin, $this->card->pin)) {
            $remainingAttempts = $this->validateBlockCard();
            throw ValidationException::withMessages([
                'pin' => 'PIN is incorrect. You have ' . $remainingAttempts . ' more attempts.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.modals.withdraw-modal');
    }
}
