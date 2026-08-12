<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\SalesHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_analytics_controller_returns_10year_sales_data_and_forecast(): void
    {
        $category = Category::factory()->create(['name' => 'Green Energy']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        SalesHistory::create([
            'product_id' => $product->id,
            'units_sold' => 1500,
            'revenue' => 45000.00,
            'sale_date' => '2024-06-15',
        ]);

        $response = $this->get('/admin/analytics');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Admin/Analytics')
            ->has('salesTrendData')
            ->has('forecastData')
        );
    }
}
