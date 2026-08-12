<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_solar_hub_page_renders_successfully(): void
    {
        $response = $this->get('/solar-hub');
        $response->assertStatus(200);
    }

    public function test_admin_analytics_page_renders_successfully(): void
    {
        $response = $this->get('/admin/analytics');
        $response->assertStatus(200);
    }

    public function test_checkout_page_renders_successfully(): void
    {
        $response = $this->get('/checkout');
        $response->assertStatus(200);
    }
}
