<?php

namespace App\StateMachines\ProductStatus;

use App\Http\Requests\VariantRequest;
use App\Logging\GlobalLogger;
use App\Models\Product;
use App\Services\VariantService;
use Illuminate\Container\Container;
use InvalidArgumentException;

class ProductDraftState extends BaseRepairStatusState
{
    protected VariantService $variantService;

    public function listAvailableFunctions()
    {
        return ['addVariant', 'removeVariant', 'activate'];
    }

    public function setVariantService()
    {
        $this->variantService = Container::getInstance()->make(VariantService::class);
    }

    function addVariant(VariantRequest $request)
    {
        GlobalLogger::log('apiLog', 'Variant added');
        $this->variantService->create($request);
    }

    function removeVaraint()
    {
        GlobalLogger::log('apiLog', 'Variant removed');
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
        GlobalLogger::log('apiLog', 'Status moved to activated');
        $this->product->update([
            'product_status_id' => 2,
            'activated_by' => auth()->user()->id,
            'valid_from' => now(),
            'valid_to' => now()->addDays(30),
        ]);
    }
}
