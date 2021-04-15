<?php

namespace App\Http\Controllers\Admin\Absensi;

use App\Http\Controllers\Controller;
use App\Models\Admin\Kelas;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\TingkatanKelas;
use App\User;
use Illuminate\Support\Facades\Auth;

class RekapSiswaController extends Controller
{
    public function index(Request $request) {
        $data = [];
        if($request->req == 'table') {
            $data = Siswa::where('kelas_id', $request->kelas_id)
                        ->with('kelas')
                        ->orderBy('nama_lengkap')
                         ->with(['absensis' => function($q) use($request){
                             $q->where('tanggal', '>=', $request->tanggal_mulai)
                               ->where('tanggal', '<=', $request->tanggal_selesai);
                         }])->get();
            // return response()->json($data);
        }

        $kelas = Kelas::where('user_id', Auth::id())->get();

        return view('admin.absensi.rekap-siswa', compact('data', 'kelas'), ['mySekolah' => User::sekolah()]);
    }
}
