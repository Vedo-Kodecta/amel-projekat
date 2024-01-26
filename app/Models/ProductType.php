<?php

namespace App\Models;

use App\Http\Requests\ProductTypeRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeCreateProductType($query, ProductTypeRequest $request)
    {
        return $query->create($request->validated());
    }
}
