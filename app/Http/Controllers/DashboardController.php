<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\Supplier;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_items' => Item::count(),
            'low_stock_items' => Item::lowStock()->count(),
            'total_suppliers' => Supplier::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'total_stock_value' => Item::sum(DB::raw('quantity * unit_price')),
        ];

        $recentTransactions = Transaction::with(['item', 'user'])
            ->orderBy('transaction_date', 'desc')
            ->limit(10)
            ->get();

        $lowStockItems = Item::with(['category', 'supplier'])
            ->lowStock()
            ->orderBy('quantity', 'asc')
            ->limit(10)
            ->get();

        // Monthly transaction data for chart
        $monthlyData = Transaction::select(
            DB::raw('MONTH(transaction_date) as month'),
            DB::raw('SUM(CASE WHEN type = "in" THEN quantity ELSE 0 END) as stock_in'),
            DB::raw('SUM(CASE WHEN type = "out" THEN quantity ELSE 0 END) as stock_out')
        )
            ->whereYear('transaction_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top items by value
        $topItems = Item::select('items.*', DB::raw('(quantity * unit_price) as total_value'))
            ->orderBy('total_value', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'stats',
            'recentTransactions',
            'lowStockItems',
            'monthlyData',
            'topItems'
        ));
    }
}
