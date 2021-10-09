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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

// Superadmin route
Route::namespace('Superadmin')
    ->name('superadmin.')
    ->middleware(['auth', 'auth.superadmin'])
    ->group(function () {
        Route::get('/superadmin', 'SuperadminController@index')
            ->name('index');

        // Slider
        Route::get('/superadmin/slider/', 'SliderController@index')
            ->name('slider');
        Route::post('/superadmin/slider/', 'SliderController@store');
        Route::get('/superadmin/slider/{id}', 'SliderController@edit');
        Route::post('/superadmin/slider/update', 'SliderController@update')
            ->name('slider.slider-update');
        Route::get('/superadmin/slider/hapus/{id}', 'SliderController@destroy');


        // List User
        Route::get('/superadmin/list-user', 'ListUserController@index')
            ->name('list-user');
        Route::post('/superadmin/list-user', 'ListUserController@store');
        Route::get('/superadmin/list-user/{id}', 'ListUserController@edit');
        Route::post('/superadmin/list-user/update', 'ListUserController@update')
            ->name('list-user-update');
        Route::get('/superadmin/list-user/hapus/{id}', 'ListUserController@destroy');

        // Route::namespace('Library')
        //     ->group(function () {
        //         Route::get('/superadmin/library/setting', 'SettingController@index')
        //             ->name('library.setting');
        //         Route::post('/superadmin/library/setting/tipe', 'SettingController@tipeStore')
        //             ->name('library-tipe');
        //         Route::get('/superadmin/library/setting/tipe/{id}', 'SettingController@editTipe');
        //         Route::put('/superadmin/library/setting/tipe/update', 'SettingController@updateTipe')
        //             ->name('library-tipe-update');
        //         Route::delete('/superadmin/library/tipe/delete/{id}', 'SettingController@deleteTipe')
        //             ->name('library-tipe-delete');

        //         Route::get('/superadmin/library/tambah-baru', 'TambahController@index')
        //             ->name('library.tambah-baru');
        // });

        // Pengumuman
        Route::namespace('Pengumuman')
            ->group(function () {
                Route::get('/admin/pengumuman', 'PengumumanController@index')
                    ->name('pengumuman.pengumuman');
                Route::post('/admin/pengumuman/pesan/add', 'PengumumanController@store')->name('pengumuman.pesan-add');
                Route::get('/admin/pengumuman/pesan/{id}', 'PengumumanController@edit');
                Route::post('/admin/pengumuman/pesan/update', 'PengumumanController@update')
                    ->name('pengumuman.pesan-update');
                Route::get('/admin/pengumuman/pesan/hapus/{id}', 'PengumumanController@destroy');
            });
    });


Auth::routes();

Route::get('/verify', 'VerifyController@index')->name('verify');
Route::get('/home', 'HomeController@index')->name('home');
