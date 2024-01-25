<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function productStatus(): BelongsTo
    {
        return $this->belongsTo(ProductStatus::class);
    }

    public function varaints(): HasMany
    {
        return $this->hasMany(Variant::class);
    }
}