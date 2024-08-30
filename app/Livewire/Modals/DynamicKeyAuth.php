<?php

namespace App\Livewire\Modals;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

class DynamicKeyAuth extends Component
{

    public $clearActive = false;

    public $modal = false;
    public $transactional = false;
    protected $listeners = [
        'toggleDynamicKeyAuthModal' => 'toggleDynamicKeyActivation',
        'openDynamicKeyAuthModal' => 'openDynamicKeyActivation',
        'closeDynamicKeyAuthModal' => 'closeDynamicKeyActivation',
    ];
    public $confirmingDynamicKeyActivation = false;
    public $code;


    public function mount($transactional = false, $modal = true, $clearActive = false){
        $this->clearActive = $clearActive;
        $this->modal = $modal;
        $this->transactional = $transactional;
    }
    public function toggleDynamicKeyActivation($transactional = false)
    {
        $this->confirmingDynamicKeyActivation = !$this->confirmingDynamicKeyActivation;
        $this->transactional = $transactional;
    }

    public function openDynamicKeyActivation($transactional = false)
    {
        $this->confirmingDynamicKeyActivation = true;
        $this->transactional = $transactional;
    }
    public function closeDynamicKeyActivation()
    {
        $this->confirmingDynamicKeyActivation = false;
    }

    public function submit()
    {
        if ((!auth()->user()->two_factor_confirmed_at && !$this->transactional) || (!auth()->user()->dynamic_key_id && $this->transactional) ){
            $this->redirectRoute('profile.show');
            return;
        }

        $this->validate();
        $user = auth()->user();
        if (!$this->transactional){
            if ($user){
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
        }else{
            $exists = User::whereHas('dynamic_password', function ($query) {
                $query->where('code', $this->code);
            })->exists();

            if ($exists) {
                $this->dispatch('transactionalDynamicKeyAuthSuccess');
                $this->confirmingDynamicKeyActivation = false;
            }else{
                throw ValidationException::withMessages([
                    'twoFactor' => 'Transactional code is invalid',
                ]);
            }
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
