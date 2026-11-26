<?php

namespace Database\Factories;

use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => null,
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => '081234567890',
            'organization' => fake()->company(),
            'quantity' => 12,
            'message' => fake()->sentence(),
            'status' => 'new',
        ];
    }
}
