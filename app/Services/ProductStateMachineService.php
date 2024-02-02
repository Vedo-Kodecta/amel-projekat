<?php

namespace App\Services;

use App\Http\Requests\VariantRequest;
use App\Http\Resources\ProductResource;
use App\Logging\GlobalLogger;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductStateMachineService 
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

        GlobalLogger::log('apiLog', 'Add variant called');
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
        GlobalLogger::log('apiLog', 'Remove variant called');
        return $this->performAction($product, function ($status) {
            $status->removeVaraint();
        });
    }

    public function activate(Product $product)
    {
        GlobalLogger::log('apiLog', 'Activate called');
        return $this->performAction($product, function ($status) {
            $status->activate();
        });
    }

    public function delete(Product $product)
    {
        GlobalLogger::log('apiLog', 'Delete called');
        return $this->performAction($product, function ($status) {
            $status->delete();
        });
    }

    public function listAvailableFunctions(Product $product)
    {
        GlobalLogger::log('apiLog', 'List available functions called');
        $currentState = $product->state();

        if ($currentState) {
            $availableFunctions = $currentState->listAvailableFunctions();

            GlobalLogger::log('apiLog', 'Available functions: ' . implode(', ', $availableFunctions));

            return $availableFunctions;
        } else {
            GlobalLogger::log('apiLog', 'Invalid state or unsupported state machine');
            return [];
        }
    }
}
