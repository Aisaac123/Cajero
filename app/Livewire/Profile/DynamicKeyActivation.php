<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

class DynamicKeyActivation extends Component
{
    use ConfirmsPasswords;

    protected $listeners = ['twoFactorEnabled' => 'refreshWhenEnabled', 'twoFactorDisabled' => 'refreshWhenDisabled'];
    public $confirmingDynamicKeyActivation = false;
    public $activatedDynamicKey = false;
    public $twoFactorAuth = false;

    public $code;
    public $recovery_code;
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
    public function confirmDynamicKeyActivation()
    {
        $this->confirmingDynamicKeyActivation = true;
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

    public function submit()
    {
        $this->validate();

        $user = auth()->user();

        if (! $user->two_factor_secret ||
            ! $user->two_factor_recovery_codes) {
            throw ValidationException::withMessages([
                'twoFactor' => 'You dont has permission to do this action',
            ]);        }

        $google2fa = new Google2FA();
        $provider = new TwoFactorAuthenticationProvider($google2fa);

        if ($provider->verify(
            decrypt($user->two_factor_secret), $this->code
        )) {
            $this->activateDynamicKey();
        } else {
            throw ValidationException::withMessages([
                'twoFactor' => 'This code is invalid',
            ]);
        }
    }

    protected $rules = [
        'code' => 'required|string|size:6',
    ];
}
