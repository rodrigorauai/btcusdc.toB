<?php

use Illuminate\Http\Request;
use App\Http\Requests\RegisterAuthRequest;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', 'ApiController@register');
Route::post('login', 'ApiController@login');
 
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
 
    Route::get('conversor', 'ConversorController@conversor');
    Route::get('wallets', 'ConversorController@getWallets');
    Route::get('btc-wallet', 'ConversorController@getBtcWallet');
    Route::get('usdc-wallet', 'ConversorController@getUsdcWallet');
    Route::get('orders', 'ConversorController@orders');

    Route::get('user', 'ApiController@getAuthUser');
});