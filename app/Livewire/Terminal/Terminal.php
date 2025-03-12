<?php

namespace App\Livewire\Terminal;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Str;
use Livewire\Component;

class Terminal extends Component
{
    public $cart = [];

    public $payment_method = 'cash';

    public $paid_amount = 0;

    public $search = '';

    public $categoryFilter = null;

    public $quantities = [];

    public $holds = [];

    public $currentHoldId = null;

    protected $listeners = ['productSelected'];

    public function filterByCategory($categoryId)
    {
        $this->categoryFilter = $categoryId;
    }

    public function updateQuantity($productId, $quantity)
    {
        $product = Product::find($productId);

        if ($quantity > 0 && $quantity <= $product->stock) {
            $this->cart[$productId]['quantity'] = $quantity;
            $this->cart[$productId]['subtotal'] = $this->cart[$productId]['price'] * $quantity;
        } elseif ($quantity <= 0) {
            $this->removeFromCart($productId);
        } else {
            $this->dispatch('error', ['message' => 'Not enough stock available']);
        }
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (! isset($this->cart[$productId])) {
            $this->cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
            ];
        } else {
            if ($this->cart[$productId]['quantity'] < $product->stock) {
                $this->cart[$productId]['quantity']++;
                $this->cart[$productId]['subtotal'] = $this->cart[$productId]['price'] * $this->cart[$productId]['quantity'];
            } else {
                $this->dispatch('error', ['message' => 'Not enough stock available']);
            }
        }
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
    }

    public function getTotal()
    {
        return collect($this->cart)->sum('subtotal');
    }

    public function getTotalWithTax()
    {
        return $this->getTotal() * 1.1;
    }

    public function canCheckout()
    {
        return ! empty($this->cart) &&
            floatval($this->paid_amount) >= $this->getTotalWithTax();
    }

    public function updated($field, $value)
    {
        if ($field === 'paid_amount') {
            $this->paid_amount = floatval($value);
        }
    }

    public function holdSale()
    {
        if (! empty($this->cart)) {
            $holdId = uniqid();
            $this->holds[$holdId] = [
                'cart' => $this->cart,
                'total' => $this->getTotal(),
                'time' => now()->format('H:i'),
            ];
            $this->reset('cart', 'paid_amount');
            $this->dispatch('sale-held');
        }
    }

    public function restoreHold($holdId)
    {
        if (isset($this->holds[$holdId])) {
            $this->cart = $this->holds[$holdId]['cart'];
            unset($this->holds[$holdId]);
        }
    }

    public function checkout()
    {
        if (! $this->canCheckout()) {
            $this->dispatch('error', ['message' => 'Please enter valid payment amount']);

            return;
        }

        $sale = Sale::create([
            'invoice_number' => 'INV-'.strtoupper(Str::random(8)),
            'total_amount' => $this->getTotal(),
            'paid_amount' => $this->paid_amount,
            'change_amount' => $this->paid_amount - $this->getTotal(),
            'payment_method' => $this->payment_method,
            'user_id' => auth()->id(),
        ]);

        foreach ($this->cart as $productId => $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);

            // Update stock
            Product::find($productId)->decrement('stock', $item['quantity']);
        }

        $this->reset('cart', 'paid_amount');
        $this->dispatch('saleComplete', $sale->id);
    }

    public function render()
    {
        $query = Product::query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->whereAny(['name', 'sku'], 'like', "%{$this->search}%");
                });
            })
            ->when($this->categoryFilter, function ($q) {
                $q->where('category_id', $this->categoryFilter);
            });

        return view('livewire.terminal.terminal', [
            'products' => $query->get(),
            'categories' => Category::all(),
        ]);
    }
}
