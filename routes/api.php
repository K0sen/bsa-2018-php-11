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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('v1/lots/{id}', 'Lot\Api\LotController@getLot')
    ->where('id', '[0-9]+')
    ->name('getLotApi');
Route::get('v1/lots', 'Lot\Api\LotController@getLots')->name('getLotsApi');

Route::post('v1/lots', 'Lot\Api\LotController@addLot')->name('addLotApi');
Route::post('v1/trades', 'Lot\Api\LotController@addTrade')->name('addTradeApi');