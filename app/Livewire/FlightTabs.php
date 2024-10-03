<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Flight;

class FlightTabs extends Component
{
    public $flight;
    public $activeTab;

    protected $listeners = ['setActiveTab'];

    public function mount(Flight $flight, $tab = null)
    {
        $this->flight = $flight;
        $this->activeTab = session('activeTab', $tab ?? 'flight');
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        session(['activeTab' => $this->activeTab]);
    }

    public function render()
    {
        return view('livewire.flight-tabs');
    }
}
