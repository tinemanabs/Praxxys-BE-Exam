<?php

use App\Http\Controllers\ProductsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/products/all', [ProductsController::class, 'getAllProducts']);
Route::post('/products/store', [ProductsController::class, 'store']);
Route::post('/products/update/{id}', [ProductsController::class, 'update']);
Route::post('/products/delete/{id}', [ProductsController::class, 'delete']);
Route::post('/products/remove-image/{id}', [ProductsController::class, 'removeImage']);