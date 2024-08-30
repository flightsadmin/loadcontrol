<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Envelope extends Model
{
    protected $fillable = ['registration_id', 'envelope_type', 'x', 'y'];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}