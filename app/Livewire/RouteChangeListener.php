<?php

namespace App\Livewire;

use Livewire\Component;

class RouteChangeListener extends Component
{
    public function emitRouteChange($url)
    {
        dd(123);
        $this->dispatch('routeChanged', $url);
    }

    public function render()
    {
        return view('livewire.route-change-listener');
    }
}
