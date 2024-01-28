<?php

namespace App\Services;

use App\Http\Requests\VariantRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductStateMachineService extends BaseService
{
    private function performAction(Product $product, callable $action, ?Request $request = null)
    {
        $status = $product->state();
        $action($status, $request);
        $product->refresh();

        return ProductResource::make($product);
    }

    public function addVariant(Product $product, VariantRequest $request)
    {
        return $this->performAction(
            $product,
            function ($status, $request) {
                $status->addVariant($request);
            },
            $request
        );
    }

    public function removeVariant(Product $product)
    {
        return $this->performAction($product, function ($status) {
            $status->removeVaraint();
        });
    }

    public function activate(Product $product)
    {
        return $this->performAction($product, function ($status) {
            $status->activate();
        });
    }

    public function delete(Product $product)
    {
        return $this->performAction($product, function ($status) {
            $status->delete();
        });
    }
}
