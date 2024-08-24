<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = ['flight_id', 'hold_id', 'type', 'pieces', 'weight'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function hold()
    {
        return $this->belongsTo(Hold::class);
    }
}
