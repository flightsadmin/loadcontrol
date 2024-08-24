<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = ['registration_id', 'flight_number', 'departure', 'arrival'];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }
}
