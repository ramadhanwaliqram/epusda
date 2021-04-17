<?php

use Illuminate\Http\Request;

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

Route::post('login', 'API\AuthControllerAPI@loginUser');
Route::post('register', 'API\RegisterControllerAPI@addUser');

Route::get('email/verify/{id}', 'API\VerificationControllerAPI@verify')->name('verification.verify');
Route::get('email/resend', 'API\VerificationControllerAPI@resend')->name('verification.resend');