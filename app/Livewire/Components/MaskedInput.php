<?php

namespace App\Livewire\Components;

use Livewire\Component;

class MaskedInput extends Component
{
    public $modelValue = '';

    public function mount($value = '')
    {
        $this->modelValue = $value;
    }

    public function updatedModelValue($value)
    {
        $this->modelValue = preg_replace('/[^0-9]/', '', substr($value, 0, 4));
        $this->dispatch('input-updated', $this->modelValue);
    }

    public function render()
    {
        return view('livewire.components.masked-input');
    }
}
