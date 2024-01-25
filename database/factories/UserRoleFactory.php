<?php

namespace Database\Factories;

use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserRole>
 */
class UserRoleFactory extends Factory
{
    protected $model = UserRole::class;

    public function definition()
    {
        return [
            'role_name' => $this->faker->randomElement(['customer', 'admin']),
        ];
    }

    public function customer()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_name' => 'customer',
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_name' => 'admin',
            ];
        });
    }
}
