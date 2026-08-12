<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\RfqRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RfqTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_submit_custom_rfq_negotiation(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'moq' => 10,
        ]);

        $payload = [
            'product_id' => $product->id,
            'company_name' => 'Besmart Global Logistics',
            'contact_email' => 'procurement@besmart.com',
            'contact_phone' => '+880 1700 000000',
            'target_quantity' => 100,
            'target_unit_price' => 350.00,
            'delivery_deadline' => '2026-10-15',
            'packaging_specs' => 'Custom wooden crate palletizing',
        ];

        $response = $this->post('/rfq', $payload);

        $response->assertStatus(302);
        $this->assertDatabaseHas('rfq_requests', [
            'product_id' => $product->id,
            'company_name' => 'Besmart Global Logistics',
            'contact_email' => 'procurement@besmart.com',
            'target_quantity' => 100,
            'status' => 'pending',
        ]);
    }
}
