<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);
        return [
            'title' => ucwords($title),
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(100, 999),
            'sku' => 'SKU-' . strtoupper(Str::random(8)),
            'category_id' => Category::factory(),
            'retail_price' => fake()->randomFloat(2, 10, 5000),
            'stock_quantity' => fake()->numberBetween(50, 1000),
            'moq' => fake()->randomElement([1, 5, 10, 50]),
            'specifications' => [
                'Brand' => fake()->company(),
                'Material' => fake()->word(),
                'Warranty' => fake()->randomElement(['1 Year', '2 Years', 'Lifetime']),
                'Origin' => fake()->country(),
            ],
            'is_featured' => fake()->boolean(30),
            'description' => fake()->paragraph(),
            'image_url' => 'https://picsum.photos/seed/' . fake()->uuid() . '/600/600',
        ];
    }
}
