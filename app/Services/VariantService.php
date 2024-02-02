<?php

namespace App\Services;

use App\Http\Resources\VariantResource;
use App\Logging\GlobalLogger;
use App\Models\Variant;
use App\Traits\GlobalCacheTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


//TODO MODIFIKUJ VS
class VariantService extends BaseService
{

    use GlobalCacheTrait;
    private array $relations = ['product', 'variants'];

    public function getAll(?Model $model = null)
    {

        GlobalLogger::log('apiLog', 'Get all product variants called');

        return $this->getCachedData('all_variants', 60, function () use ($model) {
            $model = $model ?? Variant::class;
            $relationships = $relationships ?? $this->relations;

            $data = parent::getAll(new $model)
                ->where(['product_id' => $model::query()->getProduct()]);

            return VariantResource::collection($data->latest()->paginate());
        });
    }

    public function create($request)
    {
        GlobalLogger::log('apiLog', 'Create product variants called');
        $product = Variant::createVariant($request);

        Cache::forget('all_variants');

        return VariantResource::make(parent::create($product, $this->relations));
    }
}
