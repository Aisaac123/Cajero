<?php

namespace App\Livewire\Profile;

use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Jetstream\Http\Livewire\TwoFactorAuthenticationForm;

class TwoFactorForm extends TwoFactorAuthenticationForm
{
    public function confirmTwoFactorAuthentication(ConfirmTwoFactorAuthentication $confirm)
    {
        parent::confirmTwoFactorAuthentication($confirm);
        $this->dispatch('twoFactorEnabled');
    }
    public function disableTwoFactorAuthentication(DisableTwoFactorAuthentication $disable)
    {
        parent::disableTwoFactorAuthentication($disable);
        $this->dispatch('twoFactorDisabled');
    }
}
