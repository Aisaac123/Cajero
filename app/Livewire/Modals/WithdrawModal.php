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
    public Card $card;
    public $pin;
    public $moneyQty = 0;
    public $showModal = false;

    protected $rules = [
        'pin' => 'required|digits:4',
    ];

    protected $listeners = ['openWithdrawModal' => 'openModal', 'updateWithdrawQty' => 'updateMoneyQty'];

    public function mount(Card $card)
    {
        $this->card = $card;
    }

    public function updateMoneyQty($moneyQty)
    {
        $this->moneyQty = $moneyQty;
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

        if (!Hash::check($this->pin, $this->card->pin)) {
            throw ValidationException::withMessages([
                'pin' => 'PIN is incorrect.',
            ]);
        }
        try {
            $this->card->amount -= $this->moneyQty;
            $this->card->save();
            $data = [
                'quantity' => $this->moneyQty,
                'amount' => $this->card->amount,
                'denominations' => WithdrawService::calculateDenominations($this->moneyQty)
            ];
            $this->closeModal();
            $this->dispatch('successWithdraw', $data);
            $this->dispatch('resetTimeOut');
        }catch (Exception $e){
            throw $e;
        }
    }
    public function render()
    {
        return view('livewire.modals.withdraw-modal');
    }
}
