<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelIndex extends Model
{
    use HasFactory;

    protected $table = 'fuel_index';

    protected $fillable = ['weight', 'index', 'aircraft_type_id'];

    public function aircraftType()
    {
        return $this->belongsTo(AircraftType::class);
    }

    public static function getFuelIndex($blockFuel, $aircraftTypeId)
    {
        $lowerBound = self::where('aircraft_type_id', $aircraftTypeId)
            ->where('weight', '<=', $blockFuel)
            ->orderBy('weight', 'desc')
            ->first();

        $upperBound = self::where('aircraft_type_id', $aircraftTypeId)
            ->where('weight', '>=', $blockFuel)
            ->orderBy('weight', 'asc')
            ->first();

        if ($lowerBound && $upperBound) {
            $lowerDifference = abs($blockFuel - $lowerBound->weight);
            $upperDifference = abs($blockFuel - $upperBound->weight);

            return $lowerDifference <= $upperDifference ? $lowerBound : $upperBound;
        }

        return $lowerBound ?: $upperBound;
    }
}
