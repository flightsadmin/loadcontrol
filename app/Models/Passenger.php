<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;
    protected $fillable = [
        'flight_id',
        'type',
        'count',
        'zone',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
