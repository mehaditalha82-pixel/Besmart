<?php

namespace Database\Factories;

use App\Models\FlashDeal;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FlashDeal>
 */
class FlashDealFactory extends Factory
{
    protected $model = FlashDeal::class;

    public function definition(): array
    {
        $allocated = fake()->numberBetween(50, 500);
        return [
            'product_id' => Product::factory(),
            'discount_price' => fake()->randomFloat(2, 5, 200),
            'start_time' => now()->subHours(fake()->numberBetween(1, 12)),
            'end_time' => now()->addHours(fake()->numberBetween(12, 48)),
            'allocated_stock' => $allocated,
            'sold_stock' => fake()->numberBetween(5, $allocated - 10),
        ];
    }
}
