<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $icons = ['Car', 'Sparkles', 'Cpu', 'Leaf', 'Zap', 'ShoppingBag', 'Wrench', 'Smartphone'];
        $name = fake()->unique()->words(2, true);

        return [
            'parent_id' => null,
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'icon' => fake()->randomElement($icons),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
