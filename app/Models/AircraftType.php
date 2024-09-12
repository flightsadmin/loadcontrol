<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AircraftType extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline_id',
        'aircraft_type',
        'manufacturer',
        'max_zero_fuel_weight',
        'max_takeoff_weight',
        'max_landing_weight',
        'cabin_crew',
        'deck_crew',
        'max_fuel_weight',
        'ref_sta',
        'k_constant',
        'c_constant',
        'length_of_mac',
        'lemac',
        'settings'
    ];
    
    protected $casts = [
        'settings' => 'array',
    ];
    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function holds()
    {
        return $this->hasMany(Hold::class);
    }

    public function envelopes()
    {
        return $this->hasMany(Envelope::class);
    }

    public function cabinZones()
    {
        return $this->hasMany(CabinZone::class);
    }

    public function fuelIndexes()
    {
        return $this->hasMany(FuelIndex::class);
    }

    public function setting()
    {
        return $this->hasOne(Setting::class);
    }
}
