<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Flight;
use App\Models\Cargo;

class Loadplan extends Component
{
    public Flight $flight;
    public $selectedHold = null;

    protected $listeners = ['updateCargoHold'];

    public function mount(Flight $flight)
    {
        $this->flight = $flight->load('cargos', 'registration.aircraftType.holds');
    }

    public function updateCargoHold($cargoId, $holdId)
    {
        $cargo = Cargo::find($cargoId);
        $cargo->hold_id = $holdId;
        $cargo->save();
        $this->flight->load('cargos');
    }

    public function render()
    {
        return view('livewire.loadplan');
    }
}
