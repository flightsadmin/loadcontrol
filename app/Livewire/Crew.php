<?php

namespace App\Livewire;

use App\Models\AircraftType;
use Livewire\Component;

class Crew extends Component
{
    public $deck_crew = [];
    public $cabin_crew = [];
    public $aircraftTypeId;
    public $isEditable = false;

    public function mount($aircraftTypeId)
    {
        $this->aircraftTypeId = $aircraftTypeId;
        $aircraftType = AircraftType::findOrFail($this->aircraftTypeId);
        $this->deck_crew = $aircraftType->settings['deck_crew'] ?? [['location' => '', 'max_number' => '', 'arm' => '', 'index' => '']];
        $this->cabin_crew = $aircraftType->settings['cabin_crew'] ?? [['location' => '', 'max_number' => '', 'arm' => '', 'index' => '']];
    }

    public function toggleEdit()
    {
        $this->isEditable = !$this->isEditable;
    }
    public function addCrew()
    {
        $this->cabin_crew[] = ['location' => '', 'max_number' => '', 'arm' => '', 'index' => ''];
    }

    public function removeCrew($index)
    {
        unset($this->cabin_crew[$index]);
        $this->cabin_crew = array_values($this->cabin_crew);
    }

    public function save()
    {
        $this->validate([
            'deck_crew.*.location' => 'required|string',
            'deck_crew.*.max_number' => 'required|numeric',
            'deck_crew.*.arm' => 'required|numeric',
            'deck_crew.*.index' => 'required|numeric',
            'cabin_crew.*.location' => 'required|string',
            'cabin_crew.*.max_number' => 'required|numeric',
            'cabin_crew.*.arm' => 'required|numeric',
            'cabin_crew.*.index' => 'required|numeric',
        ]);

        $aircraftType = AircraftType::findOrFail($this->aircraftTypeId);
        $aircraftType->settings = array_merge($aircraftType->settings ?? [], [
            'deck_crew' => $this->deck_crew,
            'cabin_crew' => $this->cabin_crew
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
        return view('livewire.crew');
    }
}
