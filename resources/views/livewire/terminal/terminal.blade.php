<div>
    <div class="pos-container">
        <div class="row g-3 h-100">
            <div class="col-md-8">
                <div class="card shadow-none h-100">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <div class="input-group w-50">
                            <span class="input-group-text bg-primary border-0 text-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" wire:model.live="search" class="form-control form-control-sm border-2"
                                placeholder="Search products...">
                        </div>
                        <div class="btn-group">
                            @foreach ($categories as $category)
                                <button class="btn btn-sm btn-outline-light" wire:click="filterByCategory({{ $category->id }})">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-body overflow-auto" style="height: calc(100vh - 8rem);">
                        <div class="row g-3">
                            @foreach ($products as $product)
                                <div class="col-md-4">
                                    <div class="card h-100 product-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <h6 class="card-title mb-0">{{ $product->name }}</h6>
                                                <span
                                                    class="badge bg-primary">${{ number_format($product->price, 2) }}</span>
                                            </div>
                                            <p class="small text-muted mb-2">
                                                Stock: <span
                                                    class="badge bg-{{ $product->stock <= $product->alert_stock ? 'danger' : 'success' }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </p>
                                            <button class="btn btn-sm btn-primary w-100"
                                                wire:click="addToCart({{ $product->id }})" @disabled($product->stock <= 0)>
                                                <i class="bi bi-cart-plus"></i> Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-none h-100">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h4><i class="bi bi-basket"></i> Current Sale</h4>
                        @if (!empty($holds))
                            <div class="dropdown">
                                <button class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="bi bi-clock-history"></i> Held Sales ({{ count($holds) }})
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @foreach ($holds as $holdId => $hold)
                                        <li>
                                            <button class="dropdown-item" wire:click="restoreHold('{{ $holdId }}')">
                                                <div class="d-flex justify-content-between">
                                                    <span>${{ number_format($hold['total'], 2) }}</span>
                                                    <small class="text-muted">{{ $hold['time'] }}</small>
                                                </div>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="table-responsive flex-grow-1">
                            <table class="table">
                                <thead class="table-header">
                                    <tr>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart as $productId => $item)
                                        <tr>
                                            <td class="align-middle">{{ $item['name'] }}</td>
                                            <td class="align-middle">${{ number_format($item['price'], 2) }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-secondary"
                                                        wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] - 1 }})">
                                                        <i class="bi bi-dash-lg"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                                        {{ $item['quantity'] }}
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-secondary"
                                                        wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] + 1 }})">
                                                        <i class="bi bi-plus-lg"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="align-middle">${{ number_format($item['subtotal'], 2) }}</td>
                                            <td class="align-middle">
                                                <button class="btn btn-danger btn-sm"
                                                    wire:click="removeFromCart({{ $productId }})">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-auto">
                            <div class="bg-light p-3 rounded mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Subtotal:</span>
                                    <span>${{ number_format($this->getTotal(), 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Tax (10%):</span>
                                    <span>${{ number_format($this->getTotal() * 0.1, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0">Total:</span>
                                    <span
                                        class="h4 mb-0 text-primary">${{ number_format($this->getTotal() * 1.1, 2) }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label d-block">Payment Method</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="payment_method" id="cash"
                                        wire:model="payment_method" value="cash" checked>
                                    <label class="btn btn-outline-primary" for="cash">
                                        <i class="bi bi-cash-stack"></i> Cash
                                    </label>

                                    <input type="radio" class="btn-check" name="payment_method" id="card"
                                        wire:model="payment_method" value="card">
                                    <label class="btn btn-outline-primary" for="card">
                                        <i class="bi bi-credit-card"></i> Card
                                    </label>

                                    <input type="radio" class="btn-check" name="payment_method" id="transfer"
                                        wire:model="payment_method" value="transfer">
                                    <label class="btn btn-outline-primary" for="transfer">
                                        <i class="bi bi-bank"></i> Transfer
                                    </label>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Amount Paid</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" wire:model.live="paid_amount" step="0.01"
                                            min="{{ $this->getTotalWithTax() }}" class="form-control form-control-sm"
                                            placeholder="Enter amount">
                                    </div>
                                </div>
                            </div>

                            @if ($payment_method == 'cash')
                                <div class="mt-3">
                                    <label class="form-label">Change</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" readonly
                                            value="{{ number_format($paid_amount - $this->getTotalWithTax(), 2) }}"
                                            class="form-control form-control-sm bg-light">
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between gap-2 mt-2">
                                <button class="btn btn-sm btn-warning" wire:click="holdSale"
                                    @if (empty($cart)) disabled @endif>
                                    <i class="bi bi-clock"></i> Hold Sale
                                </button>

                                <button class="btn btn-sm btn-success" wire:click="checkout"
                                    wire:loading.attr="disabled" @if (!$this->canCheckout()) disabled @endif>
                                    <i class="bi bi-receipt"></i>
                                    <span wire:loading.remove>Complete Sale</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .product-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, .125);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
        }
    </style>

    <script>
        window.addEventListener('sale-held', () => {
            Swal.fire({
                icon: 'success',
                title: 'Sale Held',
                text: 'The sale has been held successfully'
            });
        });

        window.addEventListener('error', (e) => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: e.detail.message
            });
        });
    </script>
</div>
