<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loadsheet extends Model
{
    protected $fillable = [
        'flight_id',
        'total_deadload_weight',
        'total_passengers_weight',
        'total_fuel_weight',
        'gross_weight',
        'balance'
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
