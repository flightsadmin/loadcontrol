<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Envelope extends Model
{
    protected $fillable = ['aircraft_type_id', 'envelope_type', 'weight', 'index'];

    public function aircraftType()
    {
        return $this->belongsTo(AircraftType::class);
    }
}