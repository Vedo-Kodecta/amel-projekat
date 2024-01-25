<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserRoleSeeder::class);
        $this->call(ProductStatusSeeder::class);

        // Create additional users with the predefined roles
        User::factory()->count(5)->create(['user_role_id' => 1]);
        User::factory()->count(5)->create(['user_role_id' => 2]);

        $this->call(ProductTypeSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(VariantSeeder::class);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
