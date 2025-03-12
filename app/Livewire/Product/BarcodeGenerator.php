<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class BarcodeGenerator extends Component
{
    public $selectedProducts = [];

    public function generateBarcode($productId)
    {
        $product = Product::find($productId);
        $product->generateBarcode();
        $this->dispatch('barcode-generated');
    }

    public function print()
    {
        if (empty($this->selectedProducts)) {
            return;
        }

        $products = Product::with('barcodes')
            ->whereIn('id', $this->selectedProducts)
            ->get();

        $this->dispatch('print-barcodes', ['products' => $products]);
    }

    public function render()
    {
        return view('livewire.product.barcode-generator', [
            'products' => Product::with('barcodes')->get(),
        ]);
    }
}
