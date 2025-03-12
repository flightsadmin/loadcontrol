<div>
    <div class="container-fluid py-4">
        <!-- Main Stats -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2 opacity-75">Total Products</h6>
                                <h2 class="mb-0 fw-bold">{{ $totalProducts }}</h2>
                            </div>
                            <div class="fs-1 opacity-75">
                                <i class="bi bi-collection"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2 opacity-75">Categories</h6>
                                <h2 class="mb-0 fw-bold">{{ $totalCategories }}</h2>
                            </div>
                            <div class="fs-1 opacity-75">
                                <i class="bi bi-tag"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2 opacity-75">Low Stock</h6>
                                <h2 class="mb-0 fw-bold">{{ $lowStockCount }}</h2>
                            </div>
                            <div class="fs-1 opacity-75">
                                <i class="bi bi-archive"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2 opacity-75">Today's Sales</h6>
                                <h2 class="mb-0 fw-bold">${{ number_format($todaySales, 2) }}</h2>
                            </div>
                            <div class="fs-1 opacity-75">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-secondary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2 opacity-75">Total Sales</h6>
                                <h2 class="mb-0 fw-bold">{{ $totalSales }}</h2>
                            </div>
                            <div class="fs-1 opacity-75">
                                <i class="bi bi-bag-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-dark text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2 opacity-75">Stock Value</h6>
                                <h2 class="mb-0 fw-bold">${{ number_format($stockValue, 2) }}</h2>
                            </div>
                            <div class="fs-1 opacity-75">
                                <i class="bi bi-bank"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Monthly Revenue</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Top Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($topProducts as $product)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                        <small class="text-muted">{{ $product->category->name }}</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $product->total_sold }} sold</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Wait for DOM to be ready
        document.addEventListener('livewire:initialized', function () {
            const ctx = document.getElementById('salesChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($monthlySales->pluck('month')),
                        datasets: [{
                            label: 'Monthly Revenue',
                            data: @json($monthlySales->pluck('revenue')),
                            borderColor: '#0d6efd',
                            tension: 0.1,
                            fill: true,
                            backgroundColor: 'rgba(13, 110, 253, 0.1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: value => '$' + value.toLocaleString()
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</div>