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
Route::get("market/add", [\App\Http\Controllers\VKcontroller::class, "addToMarket"])->name("addToMarket");
Route::prefix("market")->group(function () {
    Route::get("add", [\App\Http\Controllers\VKcontroller::class, "addToMarket"])->name("addToMarket");
    Route::get('getMarketProduct', [\App\Http\Controllers\VKcontroller::class, "getMarketProducts"])->name("getMarketProducts");
    Route::get('cleanMarket', [\App\Http\Controllers\VKcontroller::class, "cleanMarket"])->name("cleanMarket");
    Route::get('createAlbums', [\App\Http\Controllers\VKcontroller::class, "createAlbums"])->name("createAlbums");
});
