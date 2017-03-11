<?php

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
Route::post('user/balance/deposit', 'FinancialOperationsController@deposit');
Route::post('user/balance/withdraw', 'FinancialOperationsController@withdraw');
Route::get('financial-operations', 'FinancialOperationsController@index');

Route::resource('user', 'UserController', [
    'only' => ['store', 'update']
]);
