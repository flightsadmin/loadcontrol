<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin',
        'destination',
        'flight_time',
        'airline_id',
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function emails()
    {
        return $this->hasMany(Address::class);
    }
}
