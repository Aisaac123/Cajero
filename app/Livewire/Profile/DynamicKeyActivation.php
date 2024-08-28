<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Str;
use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Component;

class DynamicKeyActivation extends Component
{
    use ConfirmsPasswords;

    protected $listeners = [
        'twoFactorEnabled' => 'refreshWhenEnabled',
        'twoFactorDisabled' => 'refreshWhenDisabled',
        'dynamicKeyAuthSuccess' => 'activateDynamicKey',
    ];
    public $confirmingDynamicKeyActivation = false;
    public $activatedDynamicKey = false;
    public $twoFactorAuth = false;

    public $code;
    public function render()
    {
        return view('livewire.profile.dynamic-key-activation');
    }

    public function refreshWhenEnabled(){
        $this->reset();
    }
    public function refreshWhenDisabled(){
        $user = auth()->user();
        $user->dynamic_key_id = null;
        $user->save();
        $this->reset();
    }

    public function toggleDynamicKeyModal()
    {
        $this->dispatch('toggleDynamicKeyAuthModal');
    }

    public function activateDynamicKey()
    {
        $uuid = (string) Str::uuid();

        $user = auth()->user();
        $user->dynamic_key_id = $uuid;
        $user->save();

        $this->dispatch('dynamic-key-activated', $uuid);

        $this->activatedDynamicKey = true;
        $this->confirmingDynamicKeyActivation = false;
    }
}
