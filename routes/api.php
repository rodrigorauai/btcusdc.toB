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

    Route::prefix('admin')->group(function () {
        # ConversorController
        Route::get('conversor', 'ConversorController@conversor');
        Route::get('split', 'ConversorController@splitValues');
        Route::get('wallets', 'ConversorController@getWallets');
        Route::get('btc-wallet', 'ConversorController@getBtcWallet');
        Route::get('usdc-wallet', 'ConversorController@getUsdcWallet');
        Route::get('orders', 'ConversorController@orders');
        Route::get('products', 'ConversorController@products');
    });

    # WithdrawNetworkController
    Route::post('paynetw', 'WithdrawNetworkController@storeWithdrawNetwork');

    # WithdrawYieldController
    Route::post('payrend', 'WithdrawYieldController@storeWithdrawYield');

    Route::get('user', 'ApiController@getAuthUser');
});