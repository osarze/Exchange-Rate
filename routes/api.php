<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});


Route::middleware(['auth:api'])->group(function(){
    Route::patch('user/base_currency', [UserController::class, 'setBaseCurrency']);

    Route::get('currencies/exchange-rates', [CurrencyController::class, 'getCurrencyExchangeRate']);

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
