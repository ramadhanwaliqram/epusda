<?php

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

Route::get('/migrate', function () {
    Artisan::call('migrate');
    return "Artisan success";
});

Route::get('/migrate-fresh', function () {
    Artisan::call('migrate:fresh');
    return "Artisan success";
});

Route::get('/db-seed', function () {
    Artisan::call('db:seed');
    return "Artisan success";
});

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
