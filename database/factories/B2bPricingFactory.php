<?php

namespace Database\Factories;

use App\Models\B2bPricing;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\B2bPricing>
 */
class B2bPricingFactory extends Factory
{
    protected $model = B2bPricing::class;

    public function definition(): array
    {
        $minQty = fake()->randomElement([10, 50, 100, 500]);
        return [
            'product_id' => Product::factory(),
            'min_qty' => $minQty,
            'max_qty' => $minQty + 49,
            'unit_price' => fake()->randomFloat(2, 5, 500),
        ];
    }
}
