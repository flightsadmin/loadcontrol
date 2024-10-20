<?php

namespace App\Livewire;

use App\Models\AircraftType;
use Livewire\Component;

class Pantry extends Component
{
    public $pantries = [];

    public $aircraftTypeId;

    public $isEditable = false;

    public function mount($aircraftTypeId)
    {
        $this->aircraftTypeId = $aircraftTypeId;
        $aircraftType = AircraftType::findOrFail($this->aircraftTypeId);
        $this->pantries = $aircraftType->settings['pantries'] ?? [['name' => '', 'weight' => '', 'index' => '']];
    }

    public function toggleEdit()
    {
        $this->isEditable = ! $this->isEditable;
    }

    public function addPantry()
    {
        $this->pantries[] = ['name' => '', 'weight' => '', 'index' => ''];
    }

    public function removePantry($index)
    {
        unset($this->pantries[$index]);
        $this->pantries = array_values($this->pantries);
    }

    public function save()
    {
        $this->validate([
            'pantries.*.name' => 'required|string|max:255',
            'pantries.*.weight' => 'required|numeric|min:0',
            'pantries.*.index' => 'required|numeric',
        ]);

        $aircraftType = AircraftType::findOrFail($this->aircraftTypeId);
        $aircraftType->settings = array_merge($aircraftType->settings ?? [], [
            'pantries' => $this->pantries,
        ]);
        $aircraftType->save();
        $this->toggleEdit();
        $this->dispatch(
            'closeModal',
            icon: 'success',
            message: 'Pantries saved successfully.',
        );
    }

    public function render()
    {
        return view('livewire.pantry');
    }
}
