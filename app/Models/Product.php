<?php

namespace App\Models;

use App\Enums\EProductStatus;
use App\Http\Requests\ProductRequest;
use App\Interfaces\ProductStatusInterface;
use App\StateMachines\ProductStatus\ProductActiveState;
use App\StateMachines\ProductStatus\ProductDeletedState;
use App\StateMachines\ProductStatus\ProductDraftState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InvalidArgumentException;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'product_type_id', 'product_status_id'];

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function productStatus(): BelongsTo
    {
        return $this->belongsTo(ProductStatus::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }

    public function scopeCreateProduct($query, ProductRequest $request)
    {
        $request->merge(['product_status_id' => $request->input('product_status_id', 1)]);


        $data = $request->validated();
        $data['product_status_id'] = 1;
        return $query->create($data);
    }

    public function state(): ProductStatusInterface
    {
        return match (EProductStatus::from($this->productStatus->status)) {
            EProductStatus::DRAFT() => new ProductDraftState($this),
            EProductStatus::ACTIVE() => new ProductActiveState($this),
            EProductStatus::DELETED() => new ProductDeletedState($this),
            default => throw new InvalidArgumentException('Invalid status')
        };
    }
}
