<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['aircraft_type_id', 'settings'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function aircraftType()
    {
        return $this->belongsTo(AircraftType::class);
    }
}
