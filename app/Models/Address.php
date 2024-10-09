<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'airline_id',
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
