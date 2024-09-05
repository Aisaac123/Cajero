<?php

namespace App\Livewire;

use App\Models\Card;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CardCreateForm extends Component
{
    public $type = 'phone';
    public $card_number = '';
    public $pin = '';
    public $amount = '';
    public $description = '';

    protected $rules = [
        'type' => 'required|in:phone,card',
        'card_number' => 'required|string|min:10|max:11|unique:cards,card_number',
        'pin' => 'required|digits:4|numeric',
        'amount' => 'required|numeric|min:1',
        'description' => 'nullable|string|max:255',
    ];

    public function updatingType()
    {
        $this->reset('card_number');
        $this->resetValidation('card_number');
    }

    public function submit()
    {
        $this->businessRules();

        $this->validate();
        if ($this->type === 'phone' && strlen($this->card_number) === 10) {
            $this->card_number = '0' . $this->card_number;
        }

        Card::create([
            'type' => $this->type,
            'card_number' => $this->card_number,
            'pin' => Hash::make($this->pin),
            'amount' => $this->amount,
            'description' => $this->description,
            'user_id' => auth()->user()->id,
        ]);

        $this->reset(['type', 'card_number', 'pin', 'amount', 'description']);
        session()->flash('message', 'Card registered successfully.');
    }

    public function businessRules(){
        if (!preg_match('/^[0-9]+$/', $this->card_number)) {
            throw ValidationException::withMessages([
                'card_number' => 'Only numbers are allowed.',
            ]);
        }
        if (Card::where('card_number', ('0' . $this->card_number))->exists()) {
            throw ValidationException::withMessages([
                'card_number' => 'Phone number already exists',
            ]);
        }
        if (strlen($this->card_number) !== 11 && $this->type === 'card'){
            throw ValidationException::withMessages([
                'card_number' => 'Card number require 11 digits',
            ]);
        }
        if (str_starts_with($this->card_number, '0') !== 11 && $this->type === 'card'){
            throw ValidationException::withMessages([
                'card_number' => 'This card number can not start with 0',
            ]);
        }
        if (strlen($this->card_number) !== 10 && $this->type === 'phone'){
            throw ValidationException::withMessages([
                'card_number' => 'Phone number require 10 digits',
            ]);
        }
        if ($this->type === 'phone') {
            $allowedPrefixes = ['300', '301', '302', '315', '316', '317', '318', '319', '320', '321', '322'];
            $startsWithAllowedPrefix = false;

            foreach ($allowedPrefixes as $prefix) {
                if (str_starts_with($this->card_number, $prefix)) {
                    $startsWithAllowedPrefix = true;
                    break;
                }
            }

            if (!$startsWithAllowedPrefix) {
                throw ValidationException::withMessages([
                    'card_number' => 'Phone number is invalid',
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.card-create-form');
    }
}
