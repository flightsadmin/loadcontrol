<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loadsheet extends Model
{
    protected $fillable = [
        'flight_id',
        'user_id',
        'final',
        'edition',
        'payload_distribution',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
