<?php


Route::get('/admin', 'AdminController@index')
            ->name('index');
Route::get('/siswa-by-tahun', 'AdminController@getSiswasByTahun')
    ->name('siswa.by.tahun');

// Peserta Didik
Route::namespace('PesertaDidik')
    ->prefix('admin/peserta-didik')
    ->name('pesertadidik.')
    ->group(function () {
        Route::resource('siswa', 'SiswaController');
        // Route::get('/admin/peserta-didik/siswa', 'SiswaController@index')
        //     ->name('pesertadidik.siswa');
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

// Pelanggaran
Route::namespace('Pelanggaran')->group(function () {
    Route::get('/admin/pelanggaran/siswa', 'SiswaController@index')
        ->name('pelanggaran.siswa');
    Route::post('/admin/pelanggaran/siswa', 'SiswaController@store');
    Route::get('/admin/pelanggaran/siswa/{id}', 'SiswaController@edit');
    Route::post('/admin/pelanggaran/siswa/update', 'SiswaController@update')
        ->name('pelanggaran.siswa-update');
    Route::get('/admin/pelanggaran/siswa/hapus/{id}', 'SiswaController@destroy');

    Route::get('/admin/pelanggaran/kategori-pelanggaran', 'KategoriPelanggaranController@index')
        ->name('pelanggaran.kategori-pelanggaran');
    Route::post('/admin/pelanggaran/kategori-pelanggaran', 'KategoriPelanggaranController@store');
    Route::get('/admin/pelanggaran/kategori-pelanggaran/{id}', 'KategoriPelanggaranController@edit');
    Route::post('/admin/pelanggaran/kategori-pelanggaran/update', 'KategoriPelanggaranController@update')
        ->name('pelanggaran.kategori-pelanggaran-update');
    Route::get('/admin/pelanggaran/kategori-pelanggaran/hapus/{id}', 'KategoriPelanggaranController@destroy');

    Route::get('/admin/pelanggaran/sanksi', 'SanksiController@index')
        ->name('pelanggaran.sanksi');
    Route::post('/admin/pelanggaran/sanksi', 'SanksiController@store');
    Route::get('/admin/pelanggaran/sanksi/{id}', 'SanksiController@edit');
    Route::post('/admin/pelanggaran/sanksi/update', 'SanksiController@update')
        ->name('pelanggaran.sanksi-update');
    Route::get('/admin/pelanggaran/sanksi/hapus/{id}', 'SanksiController@destroy');



    Route::get('/admin/pelanggaran/surat-peringatan', 'SuratPeringatanController@index')
        ->name('pelanggaran.surat-peringatan');
    Route::post('/admin/pelanggaran/surat-peringatan', 'SuratPeringatanController@store');
    Route::get('/admin/pelanggaran/surat-peringatan/{id}', 'SuratPeringatanController@edit');
    Route::post('/admin/pelanggaran/surat-peringatan/update', 'SuratPeringatanController@update')
        ->name('pelanggaran.surat-peringatan-update');
    Route::get('/admin/pelanggaran/surat-peringatan/hapus/{id}', 'SuratPeringatanController@destroy');
});

// E-Voting
Route::namespace('EVoting')->group(function () {
    Route::get('/admin/e-voting/calon', 'CalonController@index')
        ->name('e-voting.calon');
    Route::post('/admin/e-voting/calon', 'CalonController@store');
    Route::get('/admin/e-voting/calon/{id}', 'CalonController@edit');
    Route::post('/admin/e-voting/calon/update', 'CalonController@update')
        ->name('e-voting.calon-update');
    Route::get('/admin/e-voting/calon/hapus/{id}', 'CalonController@destroy');


    Route::get('/admin/e-voting/posisi', 'PosisiController@index')
        ->name('e-voting.posisi');
    Route::post('/admin/e-voting/posisi', 'PosisiController@store');
    Route::get('/admin/e-voting/posisi/{id}', 'PosisiController@edit');
    Route::post('/admin/e-voting/posisi/update', 'PosisiController@update')
        ->name('e-voting.posisi-update');
    Route::get('/admin/e-voting/posisi/hapus/{id}', 'PosisiController@destroy');



    Route::get('/admin/e-voting/pemilihan', 'PemilihanController@index')
        ->name('e-voting.pemilihan');
    Route::post('/admin/e-voting/pemilihan', 'PemilihanController@store');
    Route::get('/admin/e-voting/pemilihan/{id}', 'PemilihanController@edit');
    Route::post('/admin/e-voting/pemilihan/update', 'PemilihanController@update')
        ->name('e-voting.pemilihan-update');
    Route::get('/admin/e-voting/pemilihan/hapus/{id}', 'PemilihanController@destroy')->name('e-voting.pemilihan-destroy');

    Route::get('/admin/e-voting/vote', 'VoteController@index')
        ->name('e-voting.vote');
    Route::post('/admin/e-voting/vote', 'VoteController@store');
    Route::get('/admin/e-voting/vote/{id}', 'VoteController@edit');
    Route::post('/admin/e-voting/vote/update', 'VoteController@update')
        ->name('e-voting.vote-update');
    Route::get('/admin/e-voting/vote/hapus/{id}', 'VoteController@destroy');
});

// Fungsionaris
Route::namespace('Fungsionaris')->name('fungsionaris.')->prefix('fungsionaris')->group(function () {
    Route::resource('pegawai', 'PegawaiController');
    Route::get('guru', 'GuruController@index')
        ->name('guru');
    Route::post('guru', 'GuruController@write')
        ->name('guru.write');
    Route::get('getKabupaten/{id}', 'PegawaiController@getKabupatenKota');
    Route::get('getKecamatan/{id}', 'PegawaiController@getKecamatan');
});

     // Sekolah
Route::namespace('Sekolah')->group(function () {

    // Semester
    Route::get('/admin/sekolah/semester', 'SemesterController@index')
        ->name('sekolah.semester');
    Route::post('/admin/sekolah/semester', 'SemesterController@store');
    Route::get('/admin/sekolah/semester/{id}', 'SemesterController@edit');
    Route::post('/admin/sekolah/semester/update', 'SemesterController@update')
        ->name('sekolah.semester-update');
    Route::get('/admin/sekolah/semester/hapus/{id}', 'SemesterController@destroy');

        // Tahun Ajaran
    Route::get('/admin/sekolah/tahun-ajaran', 'TahunAjaranController@index')
        ->name('sekolah.tahun-ajaran');
    Route::post('/admin/sekolah/tahun-ajaran', 'TahunAjaranController@store');
    Route::get('/admin/sekolah/tahun-ajaran/{id}', 'TahunAjaranController@edit');
    Route::post('/admin/sekolah/tahun-ajaran/update', 'TahunAjaranController@update')
        ->name('sekolah.tahun-ajaran-update');
    Route::get('/admin/sekolah/tahun-ajaran/hapus/{id}', 'TahunAjaranController@destroy');

    // Jurusan
    Route::get('/admin/sekolah/jurusan', 'JurusanController@index')
     ->name('sekolah.jurusan');
    Route::post('/admin/sekolah/jurusan', 'JurusanController@store');
    Route::get('/admin/sekolah/jurusan/{id}', 'JurusanController@edit');
    Route::post('/admin/sekolah/jurusan/update', 'JurusanController@update')
        ->name('sekolah.jurusan-update');
    Route::get('/admin/sekolah/jurusan/hapus/{id}', 'JurusanController@destroy');

    // Kelas
    Route::get('/admin/sekolah/kelas', 'KelasController@index')
    ->name('sekolah.kelas');
    Route::post('/admin/sekolah/kelas', 'KelasController@store');
    Route::get('/admin/sekolah/kelas/{id}', 'KelasController@edit')
        ->name('sekolah.kelas-edit');
    Route::post('/admin/sekolah/kelas/update', 'KelasController@update')
       ->name('sekolah.kelas-update');
    Route::get('/admin/sekolah/kelas/hapus/{id}', 'KelasController@destroy');

    // Jam Pelajaran
    Route::get('/admin/sekolah/jam', 'JamPelajaranController@index')
        ->name('sekolah.jam');
    Route::post('/admin/sekolah/jam', 'JamPelajaranController@write')
        ->name('sekolah.jam.write');
 });

// Pelajaran
Route::namespace('Pelajaran')->group(function () {
    // Pelajaran
    Route::get('/admin/pelajaran/mata-pelajaran', 'MataPelajaranController@index')
        ->name('pelajaran.mata-pelajaran');
    Route::post('/admin/pelajaran/mata-pelajaran', 'MataPelajaranController@write')
        ->name('pelajaran.mata-pelajaran.write');

    // Jadwal Pelajaran
    Route::get('/admin/pelajaran/jadwal-pelajaran', 'JadwalPelajaranController@index')
        ->name('pelajaran.jadwal-pelajaran');
    Route::post('/admin/pelajaran/jadwal-pelajaran/getJamPelajaran', 'JadwalPelajaranController@getJamPelajaran')
        ->name('pelajaran.jadwal-pelajaran.getJamPelajaran');
    Route::post('/admin/pelajaran/jadwal-pelajaran', 'JadwalPelajaranController@write')
        ->name('pelajaran.jadwal-pelajaran.write');
});

// Absensi
Route::namespace('Absensi')->group(function () {
    Route::get('/admin/absensi/siswa', 'SiswaController@index')
        ->name('absensi.siswa');
    Route::post('/admin/absensi/siswa', 'SiswaController@write')
        ->name('absensi.siswa.write');
    Route::get('/admin/absensi/rekap-siswa', 'RekapSiswaController@index')
        ->name('absensi.rekap-siswa');
});

// Daftar Nilai
Route::resource('daftar-nilai', 'DaftarNilai\DaftarNilaiController');
Route::namespace('DaftarNilai')->group(function () {

    Route::get('/admin/daftar-nilai', 'DaftarNilaiController@index')
        ->name('daftar-nilai');
    Route::post('/admin/daftar-nilai', 'DaftarNilaiController@store')->name('daftar-nilai.store');
    Route::put('/admin/daftar-nilai', 'DaftarNilaiController@update')->name('daftar-nilai.update');
    Route::delete('/admin/daftar-nilai', 'DaftarNilaiController@destroy')->name('daftar-nilai.destroy');
});

// Kalender
Route::namespace('Kalender')->group(function () {
    Route::get('/admin/kalender/kalender-akademik', 'KalenderAkademikController@index')
        ->name('kalender.kalender-akademik');
    Route::post('/admin/kalender/tambah', 'KalenderAkademikController@store')->name('kalender.tambah-event');
    Route::post('/admin/kalender/update/{id}', 'KalenderAkademikController@update')->name('kalender.edit-event');
    Route::get('/admin/kalender/hapus/{id}', 'KalenderAkademikController@destroy');
});

// Import
Route::namespace('Import')->group(function () {
    Route::get('/admin/import/import-siswa', 'SiswaController@index')
        ->name('import.import-siswa');
    Route::post('/admin/import/import-siswa/import_excel', 'SiswaController@import_excel')
        ->name('import.import-siswa.import_excel');
});

// E-Rapor
Route::namespace('ERapor')->group(function () {
    Route::get('/admin/e-rapor/kenaikan-kelas', 'KenaikanKelasController@index')
        ->name('e-rapor.kenaikan-kelas');
    Route::post('/admin/e-rapor/kenaikan-kelas/get', 'KenaikanKelasController@index')
        ->name('e-rapor.kenaikan-kelas.get');
    Route::post('/admin/e-rapor/kenaikan-kelas/add', 'KenaikanKelasController@store')
        ->name('e-rapor.kenaikan-kelas.add');
});

// Referensi
Route::namespace('Referensi')->group(function () {
    // Bagian Pegawai
    Route::get('/admin/referensi/bagian-pegawai', 'BagianPegawaiController@index')
        ->name('referensi.bagian-pegawai');
    Route::post('/admin/referensi/bagian-pegawai', 'BagianPegawaiController@store');
    Route::get('/admin/referensi/bagian-pegawai/{id}', 'BagianPegawaiController@edit');
    Route::post('/admin/referensi/bagian-pegawai/update', 'BagianPegawaiController@update')
        ->name('referensi.bagian-pegawai-update');
    Route::get('/admin/referensi/bagian-pegawai/hapus/{id}', 'BagianPegawaiController@destroy');

    // Status Guru
    Route::get('/admin/referensi/status-guru', 'StatusGuruController@index')
        ->name('referensi.status-guru');
    Route::post('/admin/referensi/status-guru', 'StatusGuruController@store');
    Route::get('/admin/referensi/status-guru/{id}', 'StatusGuruController@edit');
    Route::post('/admin/referensi/status-guru/update', 'StatusGuruController@update')
        ->name('referensi.status-guru-update');
    Route::get('/admin/referensi/status-guru/hapus/{id}', 'StatusGuruController@destroy');

    // Jenjang pegawai
    Route::get('/admin/referensi/jenjang-pegawai', 'JenjangPegawaiController@index')
        ->name('referensi.jenjang-pegawai');
    Route::post('/admin/referensi/jenjang-pegawai', 'JenjangPegawaiController@store');
    Route::get('/admin/referensi/jenjang-pegawai/{id}', 'JenjangPegawaiController@edit');
    Route::post('/admin/referensi/jenjang-pegawai/update', 'JenjangPegawaiController@update')
        ->name('referensi.jenjang-pegawai-update');
    Route::get('/admin/referensi/jenjang-pegawai/hapus/{id}', 'JenjangPegawaiController@destroy');

    Route::get('/admin/referensi/pengaturan-hak-akses', 'PengaturanHakAksesController@index')
        ->name('referensi.pengaturan-hak-akses');
    Route::post('/admin/referensi/pengaturan-hak-akses/update', 'PengaturanHakAksesController@update')
        ->name('referensi.pengaturan-hak-akses-update');

    // Tingkatan Kelas
    Route::get('/admin/referensi/tingkatan-kelas', 'TingkatanKelasController@index')
        ->name('referensi.tingkatan-kelas');
    Route::post('/admin/referensi/tingkatan-kelas', 'TingkatanKelasController@store');
    Route::get('/admin/referensi/tingkatan-kelas/{id}', 'TingkatanKelasController@edit');
    Route::post('/admin/referensi/tingkatan-kelas/update', 'TingkatanKelasController@update')
        ->name('referensi.tingkatan-kelas-update');
    Route::get('/admin/referensi/tingkatan-kelas/hapus/{id}', 'TingkatanKelasController@destroy');
});

// Kalender
Route::namespace('Kalender')->group(function () {
    Route::get('/admin/kalender/kalender-akademik', 'KalenderAkademikController@index')
        ->name('kalender.kalender-akademik');
});

// Pengumuman
Route::namespace('Pengumuman')->group(function () {
    Route::get('/admin/pengumuman/pesan', 'PesanController@index')
        ->name('pengumuman.pesan');
    Route::post('/admin/pengumuman/pesan', 'PesanController@store');
    Route::get('/admin/pengumuman/pesan/{id}', 'PesanController@edit');
    Route::post('/admin/pengumuman/pesan/update', 'PesanController@update')
        ->name('pengumuman.pesan-update');
    Route::get('/admin/pengumuman/pesan/hapus/{id}', 'PesanController@destroy');
});

// Perpustakaan
Route::namespace('Perpustakaan')->group(function () {
    Route::get('/admin/perpustakaan/peminjaman', 'PeminjamanController@index')
        ->name('perpustakaan.list-peminjam');
});