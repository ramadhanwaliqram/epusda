<?php


Route::get('/guru', 'GuruController@index')
->name('index');

// Pengumuman
Route::namespace('Pengumuman')->group(function () {
    Route::get('/guru/pengumuman/pesan', 'PesanController@index')
        ->name('pengumuman.pesan');
    Route::post('/guru/pengumuman/pesan', 'PesanController@store');
    Route::get('/guru/pengumuman/pesan/{id}', 'PesanController@edit');
    Route::post('/guru/pengumuman/pesan/update', 'PesanController@update')
        ->name('pengumuman.pesan-update');
    Route::post('/guru/pengumuman/pesan/hapus/{id}', 'PesanController@destroy');
});

// Kalender
Route::namespace('Kalender')
    ->group(function () {
        Route::get('/guru/kalender/kalender-akademik', 'KalenderAkademikController@index')
        ->name('kalender.kalender-akademik');
});

Route::namespace('Fungsionaris')
    ->group(function () {
        Route::get('/guru/fungsionaris/pegawai', 'PegawaiController@index')
        ->name('fungsionaris.pegawai');
        Route::get('/guru/fungsionaris/guru', 'GuruuController@index')
        ->name('fungsionaris.guru');
});

// Sekolah
Route::namespace('Sekolah')->group(function () {
    // Jurusan
    Route::get('/guru/sekolah/jurusan', 'JurusanController@index')
     ->name('sekolah.jurusan');
    Route::post('/guru/sekolah/jurusan', 'JurusanController@store');
    Route::get('/guru/sekolah/jurusan/{id}', 'JurusanController@edit');
    Route::post('/guru/sekolah/jurusan/update', 'JurusanController@update')
        ->name('sekolah.jurusan-update');
    Route::get('/guru/sekolah/jurusan/hapus/{id}', 'JurusanController@destroy');

    // Kelas
    Route::get('/guru/sekolah/kelas', 'KelasController@index')
    ->name('sekolah.kelas');
    Route::post('/guru/sekolah/kelas', 'KelasController@store');
    Route::get('/guru/sekolah/kelas/{id}', 'KelasController@edit')
        ->name('sekolah.kelas-edit');
    Route::post('/guru/sekolah/kelas/update', 'KelasController@update')
       ->name('sekolah.kelas-update');
    Route::get('/guru/sekolah/kelas/hapus/{id}', 'KelasController@destroy');

     // Jam Pelajaran
     Route::get('/guru/sekolah/jam', 'JamPelajaranController@index')
         ->name('sekolah.jam');
     Route::post('/guru/sekolah/jam', 'JamPelajaranController@write')
         ->name('sekolah.jam.write');
});

// Pelajaran
Route::namespace('Pelajaran')->group(function () {
    // Pelajaran
    Route::get('/guru/pelajaran/mata-pelajaran', 'MataPelajaranController@index')
        ->name('pelajaran.mata-pelajaran');
    Route::post('/guru/pelajaran/mata-pelajaran', 'MataPelajaranController@write')
        ->name('pelajaran.mata-pelajaran.write');

    // Jadwal Pelajaran
    Route::get('/guru/pelajaran/jadwal-pelajaran', 'JadwalPelajaranController@index')
        ->name('pelajaran.jadwal-pelajaran');
    Route::post('/guru/pelajaran/jadwal-pelajaran', 'JadwalPelajaranController@write')
        ->name('pelajaran.jadwal-pelajaran.write');
});

// Peserta Didik
Route::namespace('PesertaDidik')
    ->prefix('peserta-didik')
    ->name('pesertadidik.')
    ->group(function () {
        // Route::get('/admin/peserta-didik/siswa', 'SiswaController@index')
        //     ->name('pesertadidik.siswa');
        Route::resource('siswa', 'SiswaController');
        Route::get('alumni', 'AlumniController@index')
            ->name('alumni');
        Route::get('pindah-kelas', 'PindahKelasController@index')
            ->name('pindah-kelas');
        Route::get('tidak-naik-kelas', 'TidakNaikKelasController@index')
            ->name('tidak-naik-kelas');
        Route::get('pengaturan-siswa-per-kelas', 'PengaturanSiswaPerKelasController@index')
            ->name('pengaturan-siswa-per-kelas');
        Route::get('siswa-pindahan', 'SiswaPindahanController@index')
            ->name('siswa-pindahan');
});

// Absensi
Route::namespace('Absensi')->group(function () {
    // Route::get('/guru/absensi/siswa', 'SiswaController@index')
    //     ->name('absensi.siswa');
    // Route::post('/guru/absensi/siswa', 'SiswaController@write')
    //     ->name('absensi.siswa.write');
    // Route::get('/guru/absensi/rekap-siswa', 'RekapSiswaController@index')
    //     ->name('absensi.rekap-siswa');
    Route::get('/guru/absensi/siswaguru', 'SiswaGuruController@index')
    ->name('absensi.siswa');
    Route::post('/guru/absensi/siswa', 'SiswaGuruController@write')
        ->name('absensi.siswa.write');
    Route::get('/guru/absensi/rekap-siswaguru', 'RekapSiswaGuruController@index')
        ->name('absensi.rekap-siswa');
});

// Daftar Nilai
Route::namespace('DaftarNilai')->group(function () {
    Route::get('/guru/daftar-nilai', 'DaftarNilaiController@index')
        ->name('daftar-nilai');
});

// E-Rapor
Route::namespace('ERapor')->group(function () {
    Route::get('/admin/e-rapor/kenaikan-kelas', 'KenaikanKelasController@index')
        ->name('e-rapor.kenaikan-kelas');
});

// Pelanggaran
Route::namespace('Pelanggaran')->group(function () {
    Route::get('/guru/pelanggaran/siswa', 'SiswaController@index')
        ->name('pelanggaran.siswa');
    Route::post('/guru/pelanggaran/siswa', 'SiswaController@store');
    Route::get('/guru/pelanggaran/siswa/{id}', 'SiswaController@edit');
    Route::post('/guru/pelanggaran/siswa/update', 'SiswaController@update')
        ->name('pelanggaran.siswa-update');
    Route::get('/guru/pelanggaran/siswa/hapus/{id}', 'SiswaController@destroy');

    Route::get('/guru/pelanggaran/kategori-pelanggaran', 'KategoriPelanggaranController@index')
        ->name('pelanggaran.kategori-pelanggaran');
    Route::post('/guru/pelanggaran/kategori-pelanggaran', 'KategoriPelanggaranController@store');
    Route::get('/guru/pelanggaran/kategori-pelanggaran/{id}', 'KategoriPelanggaranController@edit');
    Route::post('/guru/pelanggaran/kategori-pelanggaran/update', 'KategoriPelanggaranController@update')
        ->name('pelanggaran.kategori-pelanggaran-update');
    Route::get('/guru/pelanggaran/kategori-pelanggaran/hapus/{id}', 'KategoriPelanggaranController@destroy');

    Route::get('/guru/pelanggaran/sanksi', 'SanksiController@index')
        ->name('pelanggaran.sanksi');
    Route::post('/guru/pelanggaran/sanksi', 'SanksiController@store');
    Route::get('/guru/pelanggaran/sanksi/{id}', 'SanksiController@edit');
    Route::post('/guru/pelanggaran/sanksi/update', 'SanksiController@update')
        ->name('pelanggaran.sanksi-update');
    Route::get('/guru/pelanggaran/sanksi/hapus/{id}', 'SanksiController@destroy');



    Route::get('/guru/pelanggaran/surat-peringatan', 'SuratPeringatanController@index')
        ->name('pelanggaran.surat-peringatan');
    Route::post('/guru/pelanggaran/surat-peringatan', 'SuratPeringatanController@store');
    Route::get('/guru/pelanggaran/surat-peringatan/{id}', 'SuratPeringatanController@edit');
    Route::post('/guru/pelanggaran/surat-peringatan/update', 'SuratPeringatanController@update')
        ->name('pelanggaran.surat-peringatan-update');
    Route::get('/guru/pelanggaran/surat-peringatan/hapus/{id}', 'SuratPeringatanController@destroy');
});

// Referensi
Route::namespace('Referensi')->group(function () {
    // Bagian Pegawai
    Route::get('/guru/referensi/bagian-pegawai', 'BagianPegawaiController@index')
        ->name('referensi.bagian-pegawai');
    Route::post('/guru/referensi/bagian-pegawai', 'BagianPegawaiController@store');
    Route::get('/guru/referensi/bagian-pegawai/{id}', 'BagianPegawaiController@edit');
    Route::post('/guru/referensi/bagian-pegawai/update', 'BagianPegawaiController@update')
        ->name('referensi.bagian-pegawai-update');
    Route::get('/guru/referensi/bagian-pegawai/hapus/{id}', 'BagianPegawaiController@destroy');

    // Semester
    Route::get('/guru/referensi/semester', 'SemesterController@index')
        ->name('referensi.semester');
    Route::post('/guru/referensi/semester', 'SemesterController@store');
    Route::get('/guru/referensi/semester/{id}', 'SemesterController@edit');
    Route::post('/guru/referensi/semester/update', 'SemesterController@update')
        ->name('referensi.semester-update');
    Route::get('/guru/referensi/semester/hapus/{id}', 'SemesterController@destroy');

    // Status Guru
    Route::get('/guru/referensi/status-guru', 'StatusGuruController@index')
        ->name('referensi.status-guru');
    Route::post('/guru/referensi/status-guru', 'StatusGuruController@store');
    Route::get('/guru/referensi/status-guru/{id}', 'StatusGuruController@edit');
    Route::post('/guru/referensi/status-guru/update', 'StatusGuruController@update')
        ->name('referensi.status-guru-update');
    Route::get('/guru/referensi/status-guru/hapus/{id}', 'StatusGuruController@destroy');

    // Jenjang pegawai
    Route::get('/guru/referensi/jenjang-pegawai', 'JenjangPegawaiController@index')
        ->name('referensi.jenjang-pegawai');
    Route::post('/guru/referensi/jenjang-pegawai', 'JenjangPegawaiController@store');
    Route::get('/guru/referensi/jenjang-pegawai/{id}', 'JenjangPegawaiController@edit');
    Route::post('/guru/referensi/jenjang-pegawai/update', 'JenjangPegawaiController@update')
        ->name('referensi.jenjang-pegawai-update');
    Route::get('/guru/referensi/jenjang-pegawai/hapus/{id}', 'JenjangPegawaiController@destroy');

    Route::get('/guru/referensi/pengaturan-hak-akses', 'PengaturanHakAksesController@index')
        ->name('referensi.pengaturan-hak-akses');
    Route::post('/guru/referensi/pengaturan-hak-akses/update', 'PengaturanHakAksesController@update')
        ->name('referensi.pengaturan-hak-akses-update');

    // Tingkatan Kelas
    Route::get('/guru/referensi/tingkatan-kelas', 'TingkatanKelasController@index')
        ->name('referensi.tingkatan-kelas');
    Route::post('/guru/referensi/tingkatan-kelas', 'TingkatanKelasController@store');
    Route::get('/guru/referensi/tingkatan-kelas/{id}', 'TingkatanKelasController@edit');
    Route::post('/guru/referensi/tingkatan-kelas/update', 'TingkatanKelasController@update')
        ->name('referensi.tingkatan-kelas-update');
    Route::get('/guru/referensi/tingkatan-kelas/hapus/{id}', 'TingkatanKelasController@destroy');
});

// E-Voting
Route::namespace('EVoting')->group(function () {
    Route::get('/guru/e-voting/calon', 'CalonController@index')
        ->name('e-voting.calon');
    Route::post('/guru/e-voting/calon', 'CalonController@store');
    Route::get('/guru/e-voting/calon/{id}', 'CalonController@edit');
    Route::post('/guru/e-voting/calon/update', 'CalonController@update')
        ->name('e-voting.calon-update');
    Route::get('/guru/e-voting/calon/hapus/{id}', 'CalonController@destroy');


    Route::get('/guru/e-voting/posisi', 'PosisiController@index')
        ->name('e-voting.posisi');
    Route::post('/guru/e-voting/posisi', 'PosisiController@store');
    Route::get('/guru/e-voting/posisi/{id}', 'PosisiController@edit');
    Route::post('/guru/e-voting/posisi/update', 'PosisiController@update')
        ->name('e-voting.posisi-update');
    Route::get('/guru/e-voting/posisi/hapus/{id}', 'PosisiController@destroy');



    Route::get('/guru/e-voting/pemilihan', 'PemilihanController@index')
        ->name('e-voting.pemilihan');
    Route::post('/guru/e-voting/pemilihan', 'PemilihanController@store');
    Route::get('/guru/e-voting/pemilihan/{id}', 'PemilihanController@edit');
    Route::post('/guru/e-voting/pemilihan/update', 'PemilihanController@update')
        ->name('e-voting.pemilihan-update');
    Route::get('/guru/e-voting/pemilihan/hapus/{id}', 'PemilihanController@destroy')->name('e-voting.pemilihan-destroy');

    Route::get('/guru/e-voting/vote', 'VoteController@index')
        ->name('e-voting.vote');
    Route::post('/guru/e-voting/vote', 'VoteController@store');
    Route::get('/guru/e-voting/vote/{id}', 'VoteController@edit');
    Route::post('/guru/e-voting/vote/update', 'VoteController@update')
        ->name('e-voting.vote-update');
    Route::get('/guru/e-voting/vote/hapus/{id}', 'VoteController@destroy');
});
