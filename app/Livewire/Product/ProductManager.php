<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ProductManager extends Component
{
    use WithPagination;

    public $product_id;
    public $name;
    public $sku;
    public $description;
    public $price;
    public $stock;
    public $alert_stock;
    public $category_id;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|min:3',
        'sku' => 'required|unique:products,sku',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'alert_stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
    ];

    public function create()
    {
        $this->reset();
        $this->isEditing = false;
        $this->dispatch('show-product-modal');
    }

    public function edit(Product $product)
    {
        $this->isEditing = true;
        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alert_stock = $product->alert_stock;
        $this->category_id = $product->category_id;

        $this->dispatch('show-product-modal');
    }

    public function save()
    {
        if ($this->isEditing) {
            $this->rules['sku'] = 'required|unique:products,sku,' . $this->product_id;
        }

        $this->validate();

        $product = $this->isEditing ? Product::find($this->product_id) : new Product();
        $product->fill([
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'alert_stock' => $this->alert_stock,
            'category_id' => $this->category_id,
        ])->save();

        $this->dispatch('hide-product-modal');
        $this->dispatch('product-saved');
        $this->reset();
    }

    public function adjustStock($id, $amount)
    {
        $product = Product::find($id);
        if ($product) {
            $product->increment('stock', $amount);
        }
    }

    public function render()
    {
        return view('livewire.product.product-manager', [
            'products' => Product::where('name', 'like', "%{$this->search}%")
                ->orWhere('sku', 'like', "%{$this->search}%")
                ->paginate(10),
            'categories' => Category::all()
        ]);
    }
}
