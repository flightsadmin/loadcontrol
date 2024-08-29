<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration',
        'max_takeoff_weight',
        'basic_weight',
        'cabin_crew',
        'deck_crew',
        'passenger_zones',
        'fuel_capacity',
        'cg_range_min',
        'cg_range_max'
    ];

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    public function holds()
    {
        return $this->hasMany(Hold::class);
    }
}
