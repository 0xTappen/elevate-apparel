<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => fake()->unique()->words(3, true),
            'slug' => Str::slug(fake()->unique()->words(4, true)),
            'description' => fake()->sentence(),
            'price' => 85000,
            'material' => 'Cotton combed',
            'min_order' => 12,
            'sizes' => ['S', 'M', 'L'],
            'production_days' => 14,
            'image' => 'images/products/oversized-premium-tee.svg',
            'is_featured' => false,
            'is_active' => true,
        ];
    }
}
