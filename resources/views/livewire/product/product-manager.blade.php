<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div class="input-group w-25">
                    <span class="input-group-text border-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Search products...">
                </div>
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="bi bi-plus-circle-fill"></i> New Product
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th>SKU</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $product->stock <= $product->alert_stock ? 'danger' : 'success' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary"
                                                wire:click="edit({{ $product->id }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success"
                                                wire:click="adjustStock({{ $product->id }}, 1)">
                                                <i class="bi bi-plus-circle"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                wire:click="adjustStock({{ $product->id }}, -1)">
                                                <i class="bi bi-dash-circle"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $isEditing ? 'Edit' : 'New' }} Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="save">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SKU</label>
                            <input type="text" class="form-control" wire:model="sku">
                            @error('sku') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" wire:model="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" step="0.01" class="form-control" wire:model="price">
                                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" class="form-control" wire:model="stock">
                                @error('stock') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alert Stock Level</label>
                            <input type="number" class="form-control" wire:model="alert_stock">
                            @error('alert_stock') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" wire:model="description" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Close
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" wire:click="save">
                        <i class="bi bi-check-circle"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        const modal = new bootstrap.Modal('#productModal');

        window.addEventListener('show-product-modal', () => {
            modal.show();
        });

        window.addEventListener('hide-product-modal', () => {
            modal.hide();
        });

        window.addEventListener('product-saved', () => {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Product saved successfully'
            });
        });
    </script>
    @endscript
</div>