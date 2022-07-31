<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PotionController;
use App\Http\Controllers\SaleController;
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

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        Route::resource('potions', PotionController::class)->except([
            'create',
            'edit'
        ]);

        Route::resource('clients', ClientController::class)->except([
            'create',
            'edit'
        ]);

        Route::resource('ingredients', IngredientController::class)->except([
            'create',
            'edit'
        ]);


        Route::resource('sales', SaleController::class)->except([
            'create',
            'edit'
        ]);

        Route::post('/auth/logout', [AuthController::class, 'logout']);
    }
);