<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'name' => $this->faker->words(4, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(1, 100),
            'sku' => $this->faker->unique()->bothify('SKU-###??'),
            'published' => $this->faker->boolean(80), // 80% chance of being published
            'discount' => $this->faker->numberBetween(0, 50), // Discount percentage
            'featured' => $this->faker->boolean(10), // 10
            'short_description' => $this->faker->sentence(),
        ];
    }
}
