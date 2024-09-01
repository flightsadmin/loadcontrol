<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'aircraft_type_id',
        'basic_weight',
        'basic_index',
    ];

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    public function holds()
    {
        return $this->hasMany(Hold::class);
    }

    public function envelopes()
    {
        return $this->hasMany(Envelope::class);
    }

    public function aircraftType()
    {
        return $this->belongsTo(AircraftType::class);
    }
}
