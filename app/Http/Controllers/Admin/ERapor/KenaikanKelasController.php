<?php

namespace App\Http\Controllers\Admin\ERapor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Admin\Kelas;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KenaikanKelasController extends Controller
{
    public function index(Request $req)
    {
        $userId = auth()->user()->id;
        $kelases = DB::table('kelas')
            ->select('tingkatan_kelas.*', 'kelas.*', 'kelas.name as kelas_name', 'tingkatan_kelas.name as tingkatan_name')
            ->join('tingkatan_kelas', 'kelas.tingkatan_kelas_id', 'tingkatan_kelas.id')
            ->where('kelas.user_id', $userId)
            ->where('kelas.deleted_at', null)
            ->get();

        $data = [];
        if ($req->pilih1) {
            $data = Siswa::where('kelas_id', $req->pilih1)->get();
        }
        return view('admin.e-rapor.kenaikan-kelas', [
            'mySekolah' => User::sekolah(),
            'kelases' => $kelases,
            'data' => $data
        ]);
    }

    public function store(Request $req)
    {

        foreach ($req->nama_siswa as $siswa) {
            $data = Siswa::where('id', $siswa)->update([
                'kelas_id' => $req->kelas2
            ]);
        }

        if ($data) {
            return Redirect::back();
        }
    }
}
