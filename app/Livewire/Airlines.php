<?php

namespace App\Livewire;

use App\Models\Route;
use App\Models\Address;
use App\Models\Airline;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Airlines extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $name, $iata_code, $base, $base_iata_code, $airline_id, $keyWord, $file;
    public $origin, $destination, $flight_time, $emails = [], $email;
    public $settings = [
        'crew' => [
            'deck_crew_weight' => 85,
            'cabin_crew_weight' => 70,
        ],
        'passenger_weights' => [
            'male' => 88,
            'female' => 70,
            'child' => 35,
            'infant' => 0,
            'default' => 84,
        ],
    ];

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $airlines = Airline::latest()
            ->orWhere('name', 'LIKE', $keyWord)
            ->orWhere('iata_code', 'LIKE', $keyWord)
            ->paginate();
        return view('livewire.airlines.view', [
            'airlines' => $airlines
        ])->extends('layouts.app');
    }

    public function saveAirline()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'iata_code' => 'required|max:2|unique:airlines,id,' . $this->airline_id,
            'base' => 'required',
            'base_iata_code' => 'required',
            'settings.*' => 'array|required',
        ]);
        $validatedData['settings'] = $this->settings;
        Airline::updateOrCreate(['id' => $this->airline_id], $validatedData);

        $this->dispatch(
            'closeModal',
            icon: 'success',
            message: $this->airline_id ? 'Airline Updated Successfully.' : 'Airline Created Successfully.',
        );
        $this->reset();
    }

    public function edit($id)
    {
        $airline = Airline::findOrFail($id);
        $this->airline_id = $id;
        $this->name = $airline->name;
        $this->iata_code = $airline->iata_code;
        $this->base = $airline->base;
        $this->base_iata_code = $airline->base_iata_code;
        $this->settings = $airline->settings ?? $this->settings;
    }

    public function destroy($id)
    {
        Airline::findOrFail($id)->delete();
        $this->dispatch(
            'closeModal',
            icon: 'warning',
            message: 'Airline Deleted Successfully.',
        );
    }

    public function addEmail($email)
    {
        $this->validate(['email' => 'required|email']);
        $this->emails[] = strtolower($email);
    }

    public function removeEmail($email)
    {
        $key = array_search($email, $this->emails);

        if ($key !== false) {
            unset($this->emails[$key]);
        }
    }

    public function saveRoute()
    {
        $validatedData = $this->validate([
            'airline_id' => 'required|exists:airlines,id',
            'origin' => 'required|string|min:3|max:20',
            'destination' => 'required|string|min:3|max:20',
        ]);
        $route = Route::updateOrCreate($validatedData);
        $route->flight_time = date("H:i", strtotime(str_pad(trim($this->flight_time), 4, '0', STR_PAD_LEFT)));
        $route->save();

        $defaultAddress = ['admin@flightadmin.info'];
        $addresses = array_merge($this->emails, $defaultAddress);
        foreach ($addresses as $email) {
            $route->emails()->updateOrCreate([
                'email' => strtolower($email),
                'airline_id' => $validatedData['airline_id'],
            ]);
        }
        $this->dispatch(
            'closeModal',
            icon: 'success',
            message: $route->wasRecentlyCreated ? 'Route Created successfully.' : 'Route Updated successfully.',
        );
        $this->reset();
    }

    public function editRoute($id)
    {
        $route = Route::findOrFail($id);
        $this->airline_id = $route->airline_id;
        $this->origin = $route->origin;
        $this->destination = $route->destination;
        $this->flight_time = $route->flight_time;
        $this->emails = $route->emails()->pluck('email')->toArray();
    }

    public function deleteRoute($id)
    {
        Address::findOrFail($id)->delete();
        $this->dispatch(
            'closeModal',
            icon: 'warning',
            message: 'Route Deleted Successfully.',
        );
    }
}