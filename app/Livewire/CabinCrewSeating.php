<?php

namespace App\Livewire;

use App\Models\AircraftType;
use Livewire\Attributes\On;
use Livewire\Component;

class CabinCrewSeating extends Component
{
    public $crewSeats = [];

    public $crewLocations = [];

    public $aircraftTypeId;

    public $formattedSeats = [];

    public $isEditable = false;

    #[On('refreshAvailable')]
    public function mount($aircraftTypeId)
    {
        $this->aircraftTypeId = $aircraftTypeId;
        $aircraftType = AircraftType::findOrFail($this->aircraftTypeId);
        $this->crewLocations = $aircraftType->settings['crew_data']['cabin_crew'];
        $this->crewSeats = $aircraftType->settings['crew_data']['crewSeats'] ?? [['number' => 1]];
    }

    public function toggleEdit()
    {
        $this->isEditable = ! $this->isEditable;
    }

    public function save()
    {
        $this->validate([
            'crewSeats.*.number' => 'required|integer|distinct|min:1',
        ]);

        $aircraftType = AircraftType::findOrFail($this->aircraftTypeId);

        $settings = $aircraftType->settings ?? [];
        $settings['crew_data']['crewSeats'] = $this->crewSeats;

        $this->formatSeats();
        $settings['crew_data']['formattedSeats'] = $this->formattedSeats;

        $aircraftType->settings = $settings;
        $aircraftType->save();
        session()->flash('success', 'Cabin Crew Seating data saved successfully!');
        $this->toggleEdit();
    }

    public function addSeat()
    {
        $this->crewSeats[] = ['number' => 1];
    }

    public function removeSeat($index)
    {
        unset($this->crewSeats[$index]);
        $this->crewSeats = array_values($this->crewSeats);
    }

    public function formatSeats()
    {
        $this->formattedSeats = collect($this->crewSeats)->mapWithKeys(function ($seat) {
            $seatNumber = $seat['number'];
            $formatted = [];

            foreach ($seat as $key => $value) {
                if ($key !== 'number') {
                    $formatted[$key] = (int) ($value ?? 0);
                }
            }

            return [$seatNumber => $formatted];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.cabin-crew-seating');
    }
}