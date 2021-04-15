<?php

Route::get('/', function () {
    return view('auth/login');
});

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

Route::get('/dbal', function () {
    shell_exec('composer require doctrine/dbal');
    return "Composer success";
});

Route::get('/composer-install', function () {
    shell_exec('composer install');
    return "Composer success";
});

Route::middleware('auth')->group(function(){
    Route::get('/superadmin/referensi/provinsi/getKabupatenKota', 'Superadmin\Referensi\ProvinsiController@getKabupatenKota')
        ->name('superadmin.referensi.provinsi-getKabupatenKota');
    Route::get('/superadmin/referensi/kabupaten-kota/getSchools', 'Superadmin\Referensi\KabupatenKotaController@getSchools')
        ->name('superadmin.referensi.kabupaten-kota-getSchools');
    Route::get('/superadmin/referensi/kabupaten-kota/getKecamatans', 'Superadmin\Referensi\KabupatenKotaController@getKecamatans')
        ->name('superadmin.referensi.kabupaten-kota-getKecamatans');
});

Route::namespace('Guru')
    ->name('guru.')
    ->middleware(['auth', 'auth.guru'])
    ->group(__DIR__.'/web/guru.php');

Route::namespace('Siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/siswa', 'SiswaController@index')
            ->name('index');

             Route::get('/siswa/pelajaran', 'Pelajaran\MataPelajaranSiswaController@index')
             ->name('pelajaran.mata-pelajaran');
             // Route::get('/siswa/pelajaran', 'Pelajaran\MataPelajaranSiswaController@write')
             // ->name('pelajaran.mata-pelajaran.write');

             // Jadwal Pelajaran
             Route::get('/siswa/pelajaran/jadwal-pelajaran', 'Pelajaran\JadwalPelajaranSiswaController@index')
             ->name('pelajaran.jadwal-pelajaran');
         Route::post('/siswa/pelajaran/jadwal-pelajaran', 'Pelajaran\JadwalPelajaranSiswaController@write')
             ->name('pelajaran.jadwal-pelajaran.write');

        //evoting
        Route::get('/siswa/e-voting', 'EVoting\EVotingController@index')
            ->name('e-voting.e-voting');

        //bang adek
        Route::get('/siswa/pelajaran', 'Pelajaran\MataPelajaranSiswaController@index')
            ->name('pelajaran.mata-pelajaran');
        // Route::get('/siswa/pelajaran', 'Pelajaran\MataPelajaranSiswaController@write')
        // ->name('pelajaran.mata-pelajaran.write');

        // Jadwal Pelajaran
        Route::get('/siswa/pelajaran/jadwal-pelajaran', 'Pelajaran\JadwalPelajaranSiswaController@index')
            ->name('pelajaran.jadwal-pelajaran');
        Route::post('/siswa/pelajaran/jadwal-pelajaran', 'Pelajaran\JadwalPelajaranSiswaController@write')
            ->name('pelajaran.jadwal-pelajaran.write');

        Route::get('/siswa/kalender', 'Kalender\KalenderAkademikController@index')
            ->name('kalender.kalender-akademik');

        Route::get('/siswa/pengumuman', 'Pengumuman\PengumumanController@index')
            ->name('pengumuman.pengumuman');

        Route::get('/siswa/pelanggaran', 'Pelanggaran\SiswaController@index')
            ->name('pelanggaran.pelanggaran');

        Route::get('/siswa/perpustakaan', 'Perpustakaan\PerpustakaanController@index')
            ->name('perpustakaan.perpustakaan');

        Route::get('/siswa/cbt', 'Cbt\CbtSiswaController@index')
            ->name('cbt.cbt-siswa');

        Route::get('/siswa/elearning', 'Elearning\ElearningSiswaController@index')
            ->name('elearning.elearning-siswa');

        Route::get('/siswa/leaderboard', 'Leaderboard\LeaderboardSiswaController@index')
            ->name('leaderboard.leaderboard-siswa');

        Route::get('/siswa/nilai', 'Nilai\NilaiSiswaController@index')
            ->name('nilai.nilai-siswa');

        Route::get('/siswa/forum', 'Forum\ForumSiswaController@index')
            ->name('forum.forum-siswa');

        Route::get('/siswa/logout', 'Logout\LogoutSiswaController@index')
            ->name('logout.logout-siswa');
    });

Route::namespace('Orangtua')
    ->name('orangtua.')
    ->group(function () {
        Route::get('/orangtua', 'OrangtuaController@index')
            ->name('index');

        Route::get('/orangtua/pelanggaran', 'Pelanggaran\OrangtuaController@index')
            ->name('pelanggaran.pelanggaran');

        Route::get('/orangtua/kalender', 'Kalender\KalenderAkademikController@index')
            ->name('kalender.kalender-akademik');

        Route::get('/orangtua/pengumuman', 'Pengumuman\PengumumanController@index')
            ->name('pengumuman.pengumuman');

        Route::get('/orangtua/absensi', 'Absensi\AbsensiController@index')
            ->name('absensi.absensi');

        Route::get('/orangtua/nilai', 'Nilai\NilaiOrangtuaController@index')
            ->name('nilai.nilai-orangtua');
    });

Route::namespace('Superadmin')
    ->name('superadmin.')
    ->middleware(['auth', 'auth.superadmin'])
    ->group(function () {
        Route::get('/superadmin', 'SuperadminController@index')
            ->name('index');

        Route::get('/superadmin/slider', 'SliderController@index')
            ->name('slider');
        Route::post('/superadmin/slider', 'SliderController@store')
            ->name('slider.store');
        Route::get('/superadmin/slider/{id}', 'SliderController@destroy')
            ->name('slider.destroy');
        Route::get('/superadmin/slider/update/{id}', 'SliderController@edit')
            ->name('slider.update-slider');
        Route::post('/superadmin/slider/edit/{id}', 'SliderController@update')
            ->name('slider.update');

        // Berita
        Route::namespace('Berita')
            ->group(function () {
            //Berita
            Route::get('/superadmin/berita/berita', 'BeritaController@index')
                ->name('berita.berita');
            Route::post('/superadmin/berita/berita', 'BeritaController@store');
            Route::get('/superadmin/berita/berita/{id}', 'BeritaController@edit');
            Route::post('/superadmin/berita/berita/update', 'BeritaController@update')
                ->name('berita.berita-update');
            Route::get('/superadmin/berita/berita/hapus/{id}', 'BeritaController@destroy');

            // Kategori Berita
            Route::get('/superadmin/berita/kategori-berita', 'KategoriBeritaController@index')
                ->name('berita.kategori-berita');
            Route::post('/superadmin/berita/kategori-berita', 'KategoriBeritaController@store');
            Route::get('/superadmin/berita/kategori-berita/{id}', 'KategoriBeritaController@edit');
            Route::post('/superadmin/berita/kategori-berita/update', 'KategoriBeritaController@update')
                ->name('berita.kategori-berita-update');
            Route::get('/superadmin/berita/kategori-berita/hapus/{id}', 'KategoriBeritaController@destroy');


            });
        Route::get('/superadmin/list-sekolah', 'ListSekolahController@index')
            ->name('list-sekolah');
        Route::post('/superadmin/list-sekolah', 'ListSekolahController@store');
        Route::get('/superadmin/list-sekolah/{id}', 'ListSekolahController@edit');
        Route::post('/superadmin/list-sekolah/update', 'ListSekolahController@update')
            ->name('list-sekolah-update');
        Route::get('/superadmin/list-sekolah/hapus/{id}', 'ListSekolahController@destroy');


        // Referensi
        Route::namespace('Referensi')
            ->group(function () {
                // Jenis Kelamin
                Route::get('/superadmin/referensi/jenis-kelamin', 'JenisKelaminController@index')
                    ->name('referensi.jenis-kelamin');
                Route::post('/superadmin/referensi/jenis-kelamin', 'JenisKelaminController@store');
                Route::get('/superadmin/referensi/jenis-kelamin/{id}', 'JenisKelaminController@edit');
                Route::post('/superadmin/referensi/jenis-kelamin/update', 'JenisKelaminController@update')
                    ->name('referensi.jenis-kelamin-update');
                Route::get('/superadmin/referensi/jenis-kelamin/hapus/{id}', 'JenisKelaminController@destroy');

                // Agama
                Route::get('/superadmin/referensi/agama', 'AgamaController@index')
                    ->name('referensi.agama');
                Route::post('/superadmin/referensi/agama', 'AgamaController@store');
                Route::get('/superadmin/referensi/agama/{id}', 'AgamaController@edit');
                Route::post('/superadmin/referensi/agama/update', 'AgamaController@update')
                    ->name('referensi.agama-update');
                Route::get('/superadmin/referensi/agama/hapus/{id}', 'AgamaController@destroy');

                // Status Nikah
                Route::get('/superadmin/referensi/status-nikah', 'StatusNikahController@index')
                    ->name('referensi.status-nikah');
                Route::post('/superadmin/referensi/status-nikah', 'StatusNikahController@store');
                Route::get('/superadmin/referensi/status-nikah/{id}', 'StatusNikahController@edit');
                Route::post('/superadmin/referensi/status-nikah/update', 'StatusNikahController@update')
                    ->name('referensi.status-nikah-update');
                Route::get('/superadmin/referensi/status-nikah/hapus/{id}', 'StatusNikahController@destroy');

                // Provinsi
                Route::get('/superadmin/referensi/provinsi', 'ProvinsiController@index')
                    ->name('referensi.provinsi');
                Route::post('/superadmin/referensi/provinsi', 'ProvinsiController@store');
                Route::get('/superadmin/referensi/provinsi/{id}', 'ProvinsiController@edit');
                Route::post('/superadmin/referensi/provinsi/update', 'ProvinsiController@update')
                    ->name('referensi.provinsi-update');
                Route::get('/superadmin/referensi/provinsi/hapus/{id}', 'ProvinsiController@destroy');


                // Kabupaten/Kota
                Route::get('/superadmin/referensi/kabupaten-kota', 'KabupatenKotaController@index')
                    ->name('referensi.kabupaten-kota');
                Route::post('/superadmin/referensi/kabupaten-kota', 'KabupatenKotaController@store');
                Route::get('/superadmin/referensi/kabupaten-kota/{id}', 'KabupatenKotaController@edit');
                Route::post('/superadmin/referensi/kabupaten-kota/update', 'KabupatenKotaController@update')
                    ->name('referensi.kabupaten-kota-update');
                Route::get('/superadmin/referensi/kabupaten-kota/hapus/{id}', 'KabupatenKotaController@destroy');

                // Kecamatan
                Route::get('/superadmin/referensi/kecamatan', 'KecamatanController@index')
                    ->name('referensi.kecamatan');
                Route::post('/superadmin/referensi/kecamatan', 'KecamatanController@store');
                Route::get('/superadmin/referensi/kecamatan/{id}', 'KecamatanController@edit');
                Route::post('/superadmin/referensi/kecamatan/update', 'KecamatanController@update')
                    ->name('referensi.kecamatan-update');
                Route::get('/superadmin/referensi/kecamatan/hapus/{id}', 'KecamatanController@destroy');

                // Suku
                Route::get('/superadmin/referensi/suku', 'SukuController@index')
                    ->name('referensi.suku');
                Route::post('/superadmin/referensi/suku', 'SukuController@store');
                Route::get('/superadmin/referensi/suku/{id}', 'SukuController@edit');
                Route::post('/superadmin/referensi/suku/update', 'SukuController@update')
                    ->name('referensi.suku-update');
                Route::get('/superadmin/referensi/suku/hapus/{id}', 'SukuController@destroy');
            });

        // Library Setting
        Route::namespace('Library')
            ->group(function () {
                Route::get('/superadmin/library/setting', 'SettingController@index')
                    ->name('library-setting');
                Route::post('/superadmin/library/setting/tipe', 'SettingController@tipeStore')
                    ->name('library-tipe');
                Route::get('/superadmin/library/setting/tipe/{id}', 'SettingController@editTipe');
                Route::put('/superadmin/library/setting/tipe/update', 'SettingController@updateTipe')
                    ->name('library-tipe-update');
                Route::delete('/superadmin/library/tipe/delete/{id}', 'SettingController@deleteTipe')
                    ->name('library-tipe-delete');

                Route::get('/superadmin/library', 'TambahController@index')
                    ->name('library');
            });
    });

Route::namespace('Superadmin')
    ->name('superadmin.')
    ->prefix('superadmin')
    ->middleware(['auth', 'auth.superadmin'])
    ->group(function () {
        Route::get('/', 'SuperadminController@index')->name('index');

        Route::resource('berita', 'Berita\BeritaController');

        Route::resource('library', 'Library\TambahController');
        Route::namespace('Library')
            ->group(function () {
                Route::resource('library-kategori', 'KategoriController');
                Route::resource('library-penulis', 'PenulisController');
                Route::resource('library-penerbit', 'PenerbitController');
                Route::resource('library-tingkat', 'TingkatController');
            });
    });

Route::namespace('Admin')
    ->name('admin.')
    ->prefix('admin')
    ->middleware(['auth', 'auth.admin'])
    ->group(function () {
        // Route::get('/', 'AdminController@index')->name('index');
        // Route::get('/siswa-by-tahun', 'AdminController@getSiswasByTahun')->name('siswa.by.tahun');

        // Peserta Didik
        // Route -> Admin/PesertaDidik
        // url /admin/peserta-didik


        // Fungsionaris
        // Route -> Admin/Fungsionaris
        // url /admin/fungsionaris
        Route::namespace('Fungsionaris')
            ->prefix('fungsionaris')
            ->name('fungsionaris.')
            ->group(function () {
                // Route::resource('pegawai', 'PegawaiController');
                // Route::get('getKabupaten/{id}', 'PegawaiController@getKabupatenKota');
                // Route::get('getKecamatan/{id}', 'PegawaiController@getKecamatan');
            });
    });




Route::namespace('Admin')
    ->name('admin.')
    ->middleware(['auth', 'auth.admin'])
    ->group(__DIR__.'/web/admin.php');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
