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

    public $dynamicKeyActivated;

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

    #[On('passwordConfirmed')]
    public function confirmPassword()
    {
        $this->passwordConfirmed = true;
    }

    public function confirmnDynamicKey(){
        if ($this->dynamicKeyActivated){
            $this->dispatch('transactionalDynamicKeyAuthSuccess');
        }else{
            $this->dispatch('openDynamicKeyAuthModal', $transactional = true);
        }
    }

    #[On('transactionalDynamicKeyAuthSuccess')]
    public function dynamicKeyApprove(){
        $this->redirectRoute('cards.create');
    }

    #[On('dynamicKeyActivated')]
    public function dynamicKeyActivate(){
        $this->dynamicKeyActivated = true;
    }

    public function render()
    {
        $cards = Card::when($this->search, function ($query, $search) {
                $query->where('card_number', 'like', '%'.$search.'%')
                    ->orWhere('type', 'LIKE', "{$search}%");

            })
            ->where('user_id', auth()->user()->id)
            ->orderBy('amount', 'asc')
            ->paginate(8);

        return view('livewire.card-list', compact('cards'));
    }
}
