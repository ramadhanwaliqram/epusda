<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Superadmin\KabupatenKota;
use App\Models\Superadmin\Sekolah;
use App\Models\Superadmin\Library;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\SiswaOrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperadminController extends Controller
{
    public function index() {
        $audiobook = Library::whereNotNull('link_audio')->count();
        $videobook = Library::whereNotNull('link_video')->count();
        $ebook = Library::whereNotNull('link_ebook')->count();
        $kabupaten = KabupatenKota::count();
        $sekolah = Sekolah::count();
        $siswa = Siswa::count();
        $guru = Guru::count();
        $orangtua = SiswaOrangTua::count();

        $sd = Sekolah::where('jenjang', 'SD')->count();
        $smp = Sekolah::where('jenjang', 'SMP')->count();
        $sma = Sekolah::where('jenjang', 'SMA')->count();
        $smk = Sekolah::where('jenjang', 'SMK')->count();

        $target_siswa = 1000000;
        $target_sekolah = 170000;
        $target_kabupaten = 514;

        $target_sd = 132000;
        $target_smp = 15800;
        $target_sma = 6800;
        $target_smk = 3520;

        $persentase_sd = ($sd /$target_sd) * 100;
        $persentase_smp = ($smp /$target_smp) * 100;
        $persentase_sma = ($sma /$target_sma) * 100;
        $persentase_smk = ($smk /$target_smk) * 100;


        $persentase_siswa = ($siswa / $target_siswa) * 100;
        $persentase_sekolah = ($sekolah / $target_sekolah) * 100;
        $persentase_kabupaten = ($kabupaten / $target_kabupaten) * 100;

        // dd($persentase);

        $siswasByTahun = Siswa::groupBy('tahun')->get(DB::raw("YEAR(tanggal_masuk) AS tahun, COUNT(*) AS total"));

        return view('superadmin.index', [
            'audiobook' => $audiobook,
            'videobook' => $videobook,
            'ebook' => $ebook,
            'kabupaten' => $kabupaten,
            'sekolah' => $sekolah,
            'siswa' => $siswa,
            'guru' => $guru,
            'sd' => $sd,
            'smp' => $smp,
            'sma' => $sma,
            'smk' => $smk,
            'orangtua' => $orangtua,
            'siswasByTahun' => $siswasByTahun,
            'persentase_siswa' => $persentase_siswa,
            'persentase_sekolah' => $persentase_sekolah,
            'persentase_kabupaten' => $persentase_kabupaten,
            'persentase_sd' => $persentase_sd,
            'persentase_smp' => $persentase_smp,
            'persentase_sma' => $persentase_sma,
            'persentase_smk' => $persentase_smk,
        ]);
    }
}
