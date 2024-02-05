<?php

namespace App\Services;

use App\Http\Requests\SearchObjects\VariantSearchObject;
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

    public function create($request)
    {
        GlobalLogger::log('apiLog', 'Create product variants called');
        $product = Variant::createVariant($request);

        Cache::forget('all_variants');

        return VariantResource::make($product);
    }

    public function addFilter($searchObject, $query)
    {
        return $query;
    }

    public function includeRelation($searchObject, $query)
    {
        if ($searchObject->includeProduct) {
            $query = $query->with('product');
        }

        return $query;
    }

    public function getSearchObject($params)
    {
        return new VariantSearchObject($params);
    }

    protected function getModelClass()
    {
        return new Variant();
    }

    protected function getCachedName($key = 'getPagable')
    {
        $cacheNames = [
            'getPagable' => 'all_variants',
            'getOne' => 'one_variant',
        ];

        return $cacheNames[$key] ?? $cacheNames['getPagable'];
    }
}
