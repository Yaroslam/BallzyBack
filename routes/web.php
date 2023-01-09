<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('Shoes', \App\Http\Controllers\ShoesController::class);
Route::prefix("market")->group(function () {
    Route::get("add", [\App\Http\Controllers\VKcontroller::class, "addToMarket"])->name("addToMarket");
    Route::get('getMarketProduct', [\App\Http\Controllers\VKcontroller::class, "getMarketProducts"])->name("getMarketProducts");
    Route::get('cleanMarket', [\App\Http\Controllers\VKcontroller::class, "cleanMarket"])->name("cleanMarket");
    Route::get('createAlbums', [\App\Http\Controllers\VKcontroller::class, "createAlbums"])->name("createAlbums");
    Route::get('generateUploadFile', [\App\Http\Controllers\VKcontroller::class, "generateUploadFile"])->name("generateUploadFile");
    Route::get('test', [\App\Http\Controllers\VKcontroller::class, "test"])->name("test");
});

//Route::prefix("api")->group(function () {
//    Route::get("Shoes", [\App\Http\Controllers\ShoesApiController::class, "getAllShoes"])->name("getAllShoes");
//    Route::get("getSingleShoesInfo", [\App\Http\Controllers\ShoesApiController::class, "getSingleShoesInfo"])->name("getSingleShoesInfo");
//
//    Route::prefix("orders")->group(function () {
//        Route::post('create', [\App\Http\Controllers\OrdersApiController::class, "createOrder"]);
//        Route::post('delete', [\App\Http\Controllers\OrdersApiController::class, "deleteOrder"]);
//        Route::post('takeToWorkOrder', [\App\Http\Controllers\OrdersApiController::class, "takeToWorkOrder"]);
//        Route::post('completeOrder', [\App\Http\Controllers\OrdersApiController::class, "completeOrder"]);
//        Route::get('getAllOrders', [\App\Http\Controllers\OrdersApiController::class, "getAllOrders"]);
//        Route::get('getUserAsCustomerOrders', [\App\Http\Controllers\OrdersApiController::class, "getUserAsCustomerOrders"]);
//        Route::get('getUserAsExecutorOrders', [\App\Http\Controllers\OrdersApiController::class, "getUserAsExecutorOrders"]);
//        Route::post('refuseOrder', [\App\Http\Controllers\OrdersApiController::class, "refuseOrder"]);
//    });

//});
Route::prefix("reg")->group(function () {
        Route::post("registration", [\App\Http\Controllers\RegistrationController::class, "registration"])->name("newReg");
        Route::post("login", [\App\Http\Controllers\RegistrationController::class, "login"])->name("login");
    });
