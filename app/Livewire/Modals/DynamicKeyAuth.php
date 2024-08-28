<?php

namespace App\Livewire\Modals;

use Illuminate\Validation\ValidationException;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

class DynamicKeyAuth extends Component
{

    public $clearActive = false;

    public $modal = false;
    protected $listeners = [
        'toggleDynamicKeyAuthModal' => 'toggleDynamicKeyActivation'
    ];
    public $confirmingDynamicKeyActivation = false;
    public $code;


    public function mount($modal = true, $clearActive = false){
        $this->clearActive = $clearActive;
        $this->modal = $modal;
    }
    public function toggleDynamicKeyActivation()
    {
        $this->confirmingDynamicKeyActivation = !$this->confirmingDynamicKeyActivation;
    }

    public function submit()
    {
        $this->validate();
        if ($user = auth()->user()){
            if (! $user->two_factor_secret ||
                ! $user->two_factor_recovery_codes) {
                throw ValidationException::withMessages([
                    'twoFactor' => 'You dont has permission to do this action',
                ]);
            }
        }

        $google2fa = new Google2FA();
        $provider = new TwoFactorAuthenticationProvider($google2fa);

        if ($provider->verify(
            decrypt($user->two_factor_secret), $this->code
        )) {
            $this->dispatch('dynamicKeyAuthSuccess');
            $this->confirmingDynamicKeyActivation = false;
        } else {
            throw ValidationException::withMessages([
                'twoFactor' => 'This code is invalid',
            ]);
        }
    }
    protected $rules = [
        'code' => 'required|string|size:6',
    ];
    public function render()
    {
        return view('livewire.modals.dynamic-key-auth');
    }
}
