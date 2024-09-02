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
    public $unlocked = false;
    public $locked = false;

    public $passwordConfirmed;
    public ?Card $selectedCard = null;

    public $dynamicKeyActivated;
    public function dispatchToggleLockCard($card_number){
        $this->selectedCard = Card::where('card_number', $card_number)->firstOrFail();
        if (!$this->dynamicKeyActivated){
            $this->dispatch('setIdDynamicKeyAuthModal', $id ='cardLockToggle_');
            $this->dispatch('openDynamicKeyAuthModal', $transactional = true);
        }else{
            $this->toggleLockCard();
        }
    }
    #[On('cardLockToggle_transactionalDynamicKeyAuthSuccess')]
    public function toggleLockCard(){
        $this->selectedCard->is_blocked = !$this->selectedCard->is_blocked;
        $this->selectedCard->save();
    }
    protected $updatesQueryString = ['search', 'page', 'unlocked'];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingUnlocked()
    {
        if (!$this->unlocked){
            $this->locked = false;
        }
        $this->resetPage();
    }
    public function updatingLocked()
    {
        if (!$this->locked){
            $this->unlocked = false;
        }
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
        $cards = Card::when($this->unlocked, function ($query, $unlocked) {
                $query->where('is_blocked', !$unlocked);
            })
            ->when($this->locked, function ($query, $locked) {
                $query->where('is_blocked', $locked);
            })
            ->when($this->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('card_number', 'like', $search.'%')
                            ->orWhere('card_number', 'like', '0'.$search.'%');
                    })
                        ->orWhere('type', 'LIKE', "{$search}%");
                });
            })

            ->where('user_id', auth()->user()->id)
            ->orderBy('amount', 'asc')
            ->paginate(8);

        return view('livewire.card-list', compact('cards'));
    }
}
