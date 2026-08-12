<?php

namespace Tests\Unit;

use App\Models\B2bPricing;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_belongs_to_category(): void
    {
        $category = Category::factory()->create(['name' => 'Solar Energy']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertEquals('Solar Energy', $product->category->name);
    }

    public function test_product_has_b2b_pricings_and_flash_deal(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'retail_price' => 500.00,
        ]);

        B2bPricing::create([
            'product_id' => $product->id,
            'min_qty' => 10,
            'max_qty' => 49,
            'unit_price' => 420.00,
        ]);

        FlashDeal::create([
            'product_id' => $product->id,
            'discount_price' => 375.00,
            'start_time' => now()->subHour(),
            'end_time' => now()->addHours(12),
            'allocated_stock' => 50,
            'sold_stock' => 10,
        ]);

        $this->assertCount(1, $product->b2bPricings);
        $this->assertNotNull($product->activeFlashDeal);
        $this->assertEquals(375.00, $product->activeFlashDeal->discount_price);
    }
}
