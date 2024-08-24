<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hold extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'hold_no',
        'fwd',
        'aft',
        'restrictions'
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
