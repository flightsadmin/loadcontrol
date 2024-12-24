<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AircraftType;

class CabinCrewSeating extends Component
{
    public $crewSeats = [];
    public $aircraftTypeId;
    public $formattedSeats = [];
    public $isEditable = false;

    public function mount($aircraftTypeId)
    {
        $this->aircraftTypeId = $aircraftTypeId;
        $aircraftType = AircraftType::findOrFail($this->aircraftTypeId);
        $this->crewSeats = $aircraftType->settings['crew_data']['crewSeats'] ?? [
            ['number' => 0, 'fwd_of_fwd_door' => '', 'fwd_of_aft_door_rh' => '', 'fwd_of_aft_door_lh' => '', 'aft_of_aft_door' => ''],
            ['number' => 0, 'fwd_of_fwd_door' => '', 'fwd_of_aft_door_rh' => '', 'fwd_of_aft_door_lh' => '', 'aft_of_aft_door' => ''],
            ['number' => 0, 'fwd_of_fwd_door' => '', 'fwd_of_aft_door_rh' => '', 'fwd_of_aft_door_lh' => '', 'aft_of_aft_door' => ''],
            ['number' => 0, 'fwd_of_fwd_door' => '', 'fwd_of_aft_door_rh' => '', 'fwd_of_aft_door_lh' => '', 'aft_of_aft_door' => ''],
        ];
    }

    public function toggleEdit()
    {
        $this->isEditable = !$this->isEditable;
    }

    public function save()
    {
        $validated = $this->validate([
            'crewSeats.*.number' => 'required|integer|min:1',
            'crewSeats.*.fwd_of_fwd_door' => 'required|integer|min:0',
            'crewSeats.*.fwd_of_aft_door_rh' => 'required|integer|min:0',
            'crewSeats.*.fwd_of_aft_door_lh' => 'required|integer|min:0',
            'crewSeats.*.aft_of_aft_door' => 'required|integer|min:0',
        ]);
        $aircraftType = AircraftType::findOrFail($this->aircraftTypeId);
        $settings = $aircraftType->settings;
        $settings['crew_data']['crewSeats'] = $this->crewSeats;
        $aircraftType->settings = $settings;
        $aircraftType->save();
        session()->flash('success', 'Cabin Crew Seating data saved successfully!');
        $this->toggleEdit();
    }

    public function addSeat()
    {
        $this->crewSeats[] = [
            'number' => 0,
            'fwd_of_fwd_door' => '',
            'fwd_of_aft_door_rh' => '',
            'fwd_of_aft_door_lh' => '',
            'aft_of_aft_door' => '',
        ];
    }

    public function removeSeat($index)
    {
        unset($this->crewSeats[$index]);
        $this->crewSeats = array_values($this->crewSeats);
    }

    public function formatSeats()
    {
        $this->formattedSeats = collect($this->crewSeats)->mapWithKeys(function ($seat) {
            return [
                $seat['number'] => [
                    (int) $seat['fwd_of_fwd_door'],
                    (int) $seat['fwd_of_aft_door_rh'],
                    (int) $seat['fwd_of_aft_door_lh'],
                    (int) $seat['aft_of_aft_door'],
                ]
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.cabin-crew-seating');
    }
}
