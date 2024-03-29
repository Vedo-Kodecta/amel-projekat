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

    protected $fillable = [
        'name',
        'product_type_id',
        'product_status_id',
        'activated_by',
        'valid_from',
        'valid_to',
        'description',
    ];

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

    public function scopeCreateProduct($query, $request)
    {
        $request['product_status_id'] =  1;

        return $query->create($request);
    }

    public function state(): ProductStatusInterface
    {
        $state = match (EProductStatus::from($this->productStatus->status)) {
            EProductStatus::DRAFT() => new ProductDraftState($this),
            EProductStatus::ACTIVE() => new ProductActiveState($this),
            EProductStatus::DELETED() => new ProductDeletedState($this),
            default => throw new InvalidArgumentException('Invalid status')
        };

        if ($state instanceof ProductDraftState) {
            $state->setVariantService();
        }

        return $state;
    }
}
