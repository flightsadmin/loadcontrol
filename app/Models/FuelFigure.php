<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelFigure extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_id', 'block_fuel', 'taxi_fuel', 'trip_fuel', 'crew', 'pantry',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
