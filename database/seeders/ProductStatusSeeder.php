<?php

namespace Database\Seeders;

use App\Models\ProductStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductStatus::factory()->create(['status' => 'draft']);
        ProductStatus::factory()->create(['status' => 'active']);
        ProductStatus::factory()->create(['status' => 'deleted']);
    }
}
