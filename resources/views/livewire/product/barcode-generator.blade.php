<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Product Barcodes</h5>
                <button class="btn btn-sm btn-primary" wire:click="print" @if(empty($selectedProducts)) disabled @endif>
                    <i class="bi bi-printer"></i> Print Selected
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="form-check-input">
                                </th>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Barcode</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input" wire:model.live="selectedProducts"
                                            value="{{ $product->id }}">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>
                                        @if($product->barcodes->isNotEmpty())
                                            <span class="font-monospace">{{ $product->barcodes->first()->number }}</span>
                                        @else
                                            No barcode
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->barcodes->isEmpty())
                                            <button class="btn btn-sm btn-primary"
                                                wire:click="generateBarcode({{ $product->id }})">
                                                Generate
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Layout -->
    <div class="d-none">
        <div id="printArea">
            <style>
                .barcode-label {
                    display: inline-block;
                    text-align: center;
                    padding: 10px;
                    margin: 5px;
                    border: 1px dashed #ccc;
                }
            </style>
            <div id="barcodeContainer"></div>
        </div>
    </div>

    @script
    <script>
        window.addEventListener('print-barcodes', (event) => {
            const products = event.detail.products;
            const container = document.getElementById('barcodeContainer');
            container.innerHTML = '';

            products.forEach(product => {
                const label = document.createElement('div');
                label.className = 'barcode-label';
                label.innerHTML = `
                    <div>${product.name}</div>
                    <img src="data:image/png;base64,${product.barcode_image}" alt="${product.barcode}">
                    <div>${product.barcode}</div>
                    <div>$${product.price}</div>
                `;
                container.appendChild(label);
            });

            window.print();
        });
    </script>
    @endscript
</div>