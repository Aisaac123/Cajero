<?php

namespace App\Livewire;

use App\Models\DynamicPassword;
use Livewire\Component;

class DynamicCode extends Component
{
    public $code;

    protected $doubleRenderLimit = false;
    protected $lastPassword;

    // 1 = 0.1seg
    public $toSecondMultiplier = 4;
    public $timeLeft;
    public $deleteTimeLeft = -1;
    public $durationSeconds;


    public function mount($durationSeconds)
    {
        $this->durationSeconds = $durationSeconds * $this->toSecondMultiplier;
        $password = auth()->user()->active_dynamic_password();
        if ($password){
            $this->lastPassword = $password;
            $this->code = $password->code;
            $this->code = substr_replace($this->code, '-', 3, 0);
            $this->timeLeft = now()->diffInSeconds($this->lastPassword->expiration_time) * $this->toSecondMultiplier;
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
                'expiration_time' => now()->addSeconds($this->durationSeconds / $this->toSecondMultiplier),
            ]);
        $this->code = substr_replace($this->code, '-', 3, 0);
        $this->timeLeft = $this->durationSeconds;
    }

    public function decrementTimeLeft()
    {
        $this->doubleRenderLimit = !$this->doubleRenderLimit;
        if (!$this->doubleRenderLimit){
            $this->timeLeft--;
            $secondsToDelete = 15 * $this->toSecondMultiplier;
            $this->deleteTimeLeft = $this->deleteTimeLeft === -1 ? $this->timeLeft + $secondsToDelete : --$this->deleteTimeLeft;
            if ($this->timeLeft < -$this->toSecondMultiplier * 1.4) {
                $this->generateCode();
            }
            if ($this->deleteTimeLeft < 0) {
                DynamicPassword::firstWhere('user_id', auth()->user()->id)->delete();
                $this->deleteTimeLeft = $this->timeLeft + $secondsToDelete;
            }
        }
    }

    public function render()
    {
        return view('livewire.dynamic-code');
    }
}
