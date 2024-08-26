<?php

namespace App\Livewire;

use App\Models\DynamicPassword;
use Livewire\Component;

class DynamicCode extends Component
{
    public $code;
    protected $lastPassword;

    // 1 = 0.25seg
    public $timeLeft;
    public $deleteTimeLeft = -1;
    public $maxTime = 160;

    public function mount()
    {
        $password = auth()->user()->active_dynamic_password();
        if ($password){
            $this->lastPassword = $password;
            $this->code = $password->code;
            $this->code = substr_replace($this->code, '-', 3, 0);
            $this->timeLeft = now()->diffInSeconds($this->lastPassword->expiration_time) * 4;
        }
        else{
            DynamicPassword::where('user_id', auth()->user()->id)->delete();
            $this->generateCode();
        }
    }

    public function generateCode()
    {
        $this->code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->lastPassword = DynamicPassword::create(
            [
                'code' => $this->code,
                'user_id' => auth()->user()->id,
                'expiration_time' => now()->addSeconds($this->maxTime / 4),
            ]);
        $this->code = substr_replace($this->code, '-', 3, 0);
        $this->timeLeft = $this->maxTime;
    }

    public function decrementTimeLeft()
    {
        $this->timeLeft--;
        $this->deleteTimeLeft = $this->deleteTimeLeft === -1 ? $this->timeLeft + 60 : --$this->deleteTimeLeft;
        if ($this->timeLeft < -2) {
            $this->generateCode();
        }
        if ($this->deleteTimeLeft < 0) {
            DynamicPassword::firstWhere('user_id', auth()->user()->id)->delete();
            $this->deleteTimeLeft = $this->timeLeft + 60;
        }
    }

    public function render()
    {
        return view('livewire.dynamic-code');
    }
}
