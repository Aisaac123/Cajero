<?php

namespace App\Livewire;

use App\Models\Card;
use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CardList extends Component
{
    use WithPagination;
    use ConfirmsPasswords;
    public $search = '';
    public $passwordConfirmed;
    public ?Card $selectedCard = null;
    public $validDynamicKey = false;
    public function setSelectedCard($card_number){
        if($this->selectedCard?->card_number === $card_number){
            $this->selectedCard = null;
            return;
        }
        $this->selectedCard = Card::where('card_number', $card_number)->firstOrFail();
    }
    protected $updatesQueryString = ['search', 'page'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('dynamicKeyAuthSuccess')]
    public function transactionalDynamicKeyApprove(){
        $this->passwordConfirmed = true;
    }

    #[On('passwordConfirmed')]
    public function confirmPassword()
    {
        if (!$this->validDynamicKey){
            $this->dispatch('openDynamicKeyAuthModal');
        }else{
            $this->dispatch('dynamicKeyAuthSuccess');
        }
    }
    #[On('dynamicKeyActivated')]
    public function activatedDynamicKeyAuth(){
        $this->validDynamicKey = true;
    }

    public function render()
    {
        $cards = auth()->user()->cards()
            ->when($this->search, function ($query, $search) {
                $query->where('card_number', 'LIKE', "{$search}%")
                    ->orWhere('type', 'LIKE', "%{$search}%");
            })
            ->orderBy('amount', 'asc')
            ->paginate(8);

        return view('livewire.card-list', compact('cards'));
    }
}
