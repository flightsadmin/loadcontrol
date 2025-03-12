<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'barcode',
        'description',
        'price',
        'stock',
        'alert_stock',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function barcodes()
    {
        return $this->hasMany(Barcode::class);
    }

    public function generateBarcode()
    {
        return $this->barcodes()->create([
            'number' => 'P'.str_pad($this->id, 7, '0', STR_PAD_LEFT),
        ]);
    }
}
