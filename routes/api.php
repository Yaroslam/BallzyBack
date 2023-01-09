<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware("auth:sanctum")->prefix("orders")->group(function () {
    Route::post('create', [\App\Http\Controllers\OrdersApiController::class, "createOrder"]);
    Route::post('delete', [\App\Http\Controllers\OrdersApiController::class, "deleteOrder"]);
    Route::post('takeToWorkOrder', [\App\Http\Controllers\OrdersApiController::class, "takeToWorkOrder"]);
    Route::post('completeOrder', [\App\Http\Controllers\OrdersApiController::class, "completeOrder"]);
    Route::get('getAllOrders', [\App\Http\Controllers\OrdersApiController::class, "getAllOrders"]);
    Route::get('getUserAsCustomerOrders', [\App\Http\Controllers\OrdersApiController::class, "getUserAsCustomerOrders"]);
    Route::get('getUserAsExecutorOrders', [\App\Http\Controllers\OrdersApiController::class, "getUserAsExecutorOrders"]);
    Route::post('refuseOrder', [\App\Http\Controllers\OrdersApiController::class, "refuseOrder"]);
});

Route::get("Shoes", [\App\Http\Controllers\ShoesApiController::class, "getAllShoes"])->name("getAllShoes")->middleware(['auth:sanctum']);
Route::get("getSingleShoesInfo", [\App\Http\Controllers\ShoesApiController::class, "getSingleShoesInfo"])->name("getSingleShoesInfo")->middleware(['auth:sanctum']);
Route::middleware("auth:sanctum")->get("/name", function (Request $request) {
    return response()->json(["name" => $request->user()]);
});
