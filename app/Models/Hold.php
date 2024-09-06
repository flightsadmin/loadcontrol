<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hold extends Model
{
    use HasFactory;

    protected $fillable = [
        'aircraft_type_id',
        'hold_no',
        'fwd',
        'aft',
        'max',
        'arm',
        'index'
    ];

    public function aircraftType()
    {
        return $this->belongsTo(AircraftType::class);
    }
}
