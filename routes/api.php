<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductStateMachineController;
use App\Http\Controllers\Api\ProductTypeController;
use App\Http\Controllers\Api\VariantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('product', ProductController::class);
Route::apiResource('product-type', ProductTypeController::class);
Route::apiResource('products.variants', VariantController::class);
Route::apiResource('state-machine', ProductStateMachineController::class);

Route::prefix('/product/{product}/state-machine')->group(function () {
    Route::middleware(['auth:sanctum', 'checkUserRole:2'])->group(function () {
        Route::put('/add-variant', [ProductStateMachineController::class, 'addVaraint']);
        Route::put('/remove-variant/{variant}', [ProductStateMachineController::class, 'removeVariant']);
        Route::put('/activate', [ProductStateMachineController::class, 'activate']);
        Route::put('/delete', [ProductStateMachineController::class, 'delete']);
    });
});
