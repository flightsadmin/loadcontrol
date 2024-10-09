<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory, Notifiable;

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