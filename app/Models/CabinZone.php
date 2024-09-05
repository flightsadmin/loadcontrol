<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabinZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'aircraft_type_id',
        'zone_name',
        'fwd',
        'aft',
        'max_capacity',
        'index',
    ];

    public function aircraftType()
    {
        return $this->belongsTo(AircraftType::class);
    }
}