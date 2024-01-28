<?php

namespace App\Services;

use App\Http\Resources\VariantResource;
use App\Logging\GlobalLogger;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Model;

class VariantService extends BaseService
{

    private array $relations = ['product', 'variants'];

    public function getAll(?Model $model = null)
    {
        GlobalLogger::log('apiLog', 'Get all product variants called');
        $model = $model ?? Variant::class;
        $relationships = $relationships ?? $this->relations;

        $data = parent::getAll(new $model)
            ->where(['product_id' => $model::query()->getProduct()]);

        return VariantResource::collection($data->latest()->paginate());
    }

    public function create($request)
    {
        GlobalLogger::log('apiLog', 'Create product variants called');
        $product = Variant::createVariant($request);

        return VariantResource::make(parent::create($product, $this->relations));
    }
}
