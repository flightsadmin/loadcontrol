<?php

namespace App\Livewire\Inventory;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public function render()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $lowStockCount = Product::where('stock', '<=', DB::raw('alert_stock'))->count();
        $todaySales = Sale::whereDate('created_at', today())->sum('total_amount');

        // New metrics
        $totalSales = Sale::count();
        $monthlyRevenue = Sale::whereMonth('created_at', now()->month)->sum('total_amount');
        $topProducts = Product::withCount(['saleItems as total_sold'])
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();
        $stockValue = Product::sum(DB::raw('stock * price'));

        // Monthly sales chart data
        $monthlySales = Sale::select(
            DB::raw('sum(total_amount) as revenue'),
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->take(6)
            ->get();

        return view('livewire.inventory.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'lowStockCount',
            'todaySales',
            'totalSales',
            'monthlyRevenue',
            'topProducts',
            'stockValue',
            'monthlySales'
        ));
    }
}
