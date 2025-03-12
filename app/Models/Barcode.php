<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barcode extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'number', 'is_active'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
