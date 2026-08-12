<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\SalesHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesHistory>
 */
class SalesHistoryFactory extends Factory
{
    protected $model = SalesHistory::class;

    public function definition(): array
    {
        $units = fake()->numberBetween(10, 500);
        $unitPrice = fake()->randomFloat(2, 20, 200);

        return [
            'product_id' => Product::factory(),
            'units_sold' => $units,
            'revenue' => round($units * $unitPrice, 2),
            'sale_date' => fake()->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
        ];
    }
}
