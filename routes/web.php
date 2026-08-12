<?php

use App\Http\Controllers\RfqController;
use App\Models\Category;
use App\Models\Product;
use App\Models\SalesHistory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    // 2. Redis / Cache Optimization: Cache Category Taxonomy & Featured Products
    $categories = Cache::remember('categories_tree', 3600, function () {
        return Category::with('children')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->get();
    });

    $featuredProducts = Cache::remember('featured_products', 3600, function () {
        return Product::with(['category', 'b2bPricings', 'activeFlashDeal'])
            ->where('is_featured', true)
            ->take(8)
            ->get();
    });

    return Inertia::render('Welcome', [
        'categories' => $categories,
        'featuredProducts' => $featuredProducts,
    ]);
});

Route::get('/solar-hub', function () {
    return Inertia::render('SolarHub');
})->name('solar-hub');

Route::get('/admin/analytics', function () {
    $salesTrends = Cache::remember('sales_trends_10yr', 3600, function () {
        return SalesHistory::with('product.category')
            ->orderBy('sale_date', 'asc')
            ->get();
    });

    return Inertia::render('Admin/Analytics', [
        'salesTrendData' => $salesTrends,
    ]);
})->name('admin.analytics');

Route::get('/checkout', function () {
    return Inertia::render('Checkout');
})->name('checkout');

Route::post('/rfq', [RfqController::class, 'store'])->name('rfq.store');
