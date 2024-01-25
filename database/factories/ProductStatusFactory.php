<?php

namespace Database\Factories;

use App\Models\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductStatus>
 */
class ProductStatusFactory extends Factory
{
    protected $model = ProductStatus::class;

    public function definition()
    {
        return [
            'status' => $this->faker->randomElement(['draft', 'active', 'deleted']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (ProductStatus $repairStatus) {
            // Your additional configuration logic, if needed
        });
    }

    public function draft()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'draft',
            ];
        });
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
            ];
        });
    }

    public function deleted()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'deleted',
            ];
        });
    }
}
