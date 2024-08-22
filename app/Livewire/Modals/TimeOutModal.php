<?php

namespace App\Livewire\Modals;

use Livewire\Component;

class TimeOutModal extends Component
{
    public $show = false;

    protected $listeners = [
        'showTimeOutModal' => 'showModal',
        'redirectDashboard' => 'dashboardRedirect',
        'modalClosed' => 'handleModalClosed'
    ];

    public function showModal()
    {
        $this->show = true;
    }

    public function redirectDashboard()
    {
        return redirect()->route('dashboard');
    }

    public function handleModalClosed()
    {
        $this->show = false;
        $this->dispatch('endWithdrawing');
        $this->redirectDashboard();
    }

    public function closeModal()
    {
        $this->show = false;
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.modals.time-out-modal');
    }
}
