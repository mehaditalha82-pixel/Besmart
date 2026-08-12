<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $categories = Category::with('children')
        ->whereNull('parent_id')
        ->where('is_active', true)
        ->get();

    $featuredProducts = Product::with(['category', 'b2bPricings', 'activeFlashDeal'])
        ->where('is_featured', true)
        ->take(8)
        ->get();

    return Inertia::render('Welcome', [
        'categories' => $categories,
        'featuredProducts' => $featuredProducts,
    ]);
});

Route::get('/solar-hub', function () {
    return Inertia::render('SolarHub');
})->name('solar-hub');
