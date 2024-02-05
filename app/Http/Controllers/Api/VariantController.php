<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchObjects\VariantSearchObject;
use App\Http\Requests\VariantRequest;
use App\Http\Resources\VariantResource;
use App\Models\Product;
use App\Models\Variant;
use App\Services\VariantService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VariantController extends BaseController
{
    public function __construct(protected VariantService $variantService)
    {
        parent::__construct($variantService);
    }


    protected $requestClass = VariantRequest::class;

    public function getInsertRequestClass()
    {
        return VariantRequest::class;
    }

    public function getSearchObject($params)
    {
        return new VariantSearchObject($params);
    }

    public function createResourcePayload($request, $collection = false): VariantResource | AnonymousResourceCollection
    {
        if ($collection) {
            return VariantResource::collection($request);
        }

        return new VariantResource($request);
    }
}
