<?php

namespace Database\Factories;

use App\Models\ProductStatus;
use App\Models\ProductType;
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
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
            'product_type_id' => $this->faker->numberBetween(1, 10),
            'product_status_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
