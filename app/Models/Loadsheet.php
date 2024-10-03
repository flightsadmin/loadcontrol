<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loadsheet extends Model
{
    protected $fillable = [
        'flight_id',
        'total_traffic_load',
        'dry_operating_weight',
        'zero_fuel_weight_actual',
        'take_off_fuel',
        'take_off_weight_actual',
        'trip_fuel',
        'landing_weight_actual',
        'compartment_loads',
        'passenger_distribution',
        'index'
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
