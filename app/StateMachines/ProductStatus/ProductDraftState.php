<?php

namespace App\StateMachines\ProductStatus;

use App\Http\Requests\VariantRequest;
use App\Models\Product;
use App\Services\VariantService;
use Illuminate\Container\Container;
use InvalidArgumentException;

class ProductDraftState extends BaseRepairStatusState
{
    protected VariantService $variantService;

    public function setVariantService()
    {
        $this->variantService = Container::getInstance()->make(VariantService::class);
    }

    function addVariant(VariantRequest $request)
    {
        $this->variantService->create($request);
    }

    function removeVaraint()
    {
        $variantId = request('variant');
        $variants = $this->product->variants;

        // Find the Variant model by ID in the collection and check if it exists
        $variant = $variants->find($variantId);

        if ($variant) {
            $this->variantService->remove($variant);
        } else {
            throw new InvalidArgumentException('Invalid variant ID or variant not found.');
        }
    }

    function activate()
    {
        //TODO: NEEDS VALID FROM AND VALID TO DATES and ACTIVATED BY
        $this->product->update(['product_status_id' => 2]);
    }
}
