<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Mandatory Platform Metrics (Spec: Total produk, kategori, pelanggan, pesanan, menunggu pembayaran, telah dibayar)
        $totalProductsCount = Product::count();
        $totalCategoriesCount = Category::count();
        $totalCustomersCount = User::whereHas('role', fn($q) => $q->where('slug', 'customer'))->count();
        $totalOrdersCount = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $paidOrders = Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered', 'completed'])->count();

        // Additional helpful metrics
        $totalGmv = Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered', 'completed'])->sum('grand_total');
        $completedOrders = Order::where('status', 'completed')->count();

        // 2. Recent Transactions
        $recentOrders = Order::with(['user', 'payment', 'items'])
            ->latest()
            ->take(8)
            ->get();

        // 3. Categories Overview
        $topCategories = Category::withCount('products')
            ->orderByDesc('products_count')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalProductsCount',
            'totalCategoriesCount',
            'totalCustomersCount',
            'totalOrdersCount',
            'pendingOrders',
            'paidOrders',
            'totalGmv',
            'completedOrders',
            'recentOrders',
            'topCategories'
        ));
    }
}
