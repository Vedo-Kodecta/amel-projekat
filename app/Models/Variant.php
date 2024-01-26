<?php

namespace App\Models;

use App\Http\Requests\VariantRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'product_id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeCreateVariant($query, VariantRequest $request)
    {
        $product = $this->scopeGetProduct();

        $data = $request->validated();
        $data['product_id'] = $product->id;
        return $query->create($data);
    }

    public function scopeGetProduct()
    {
        $product = request('product');
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        } else {
            return $product;
        }
    }
}
