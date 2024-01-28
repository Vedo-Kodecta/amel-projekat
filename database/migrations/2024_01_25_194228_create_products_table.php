<?php

use App\Models\ProductStatus;
use App\Models\ProductType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->default(now());
            $table->foreignIdFor(ProductType::class);
            $table->foreignIdFor(ProductStatus::class);
            $table->foreignId('activated_by')->nullable()->constrained('users');
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
