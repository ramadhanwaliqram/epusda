<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin\PelanggaranSiswa;
use App\Models\Admin\SuratPeringatan;
use App\Models\Siswa;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelanggaranController extends Controller
{
    public function index(Request $req) {
        $pelanggarans = PelanggaranSiswa::query();

        $siswaId = $req->query('siswa_id');
        $pelanggarans->when($siswaId, function($query) use ($siswaId) {
            return $query->where('siswa_id', $siswaId);
        });

        return response()->json(ApiResponse::success($pelanggarans->get()));
    }

    public function pelanggaranSiswa(Request $req, $id) {
        $pelanggarans = PelanggaranSiswa::query();
        $suratPeringatan = SuratPeringatan::select('poin')->orderBy('poin', 'desc')->first();
        $SP = $suratPeringatan->poin;
        $poinSiswa = Siswa::query();

        // $sp = SuratPeringatan::select('poin')->orderBy('poin', 'desc')->first();
        // $ns = Siswa::select('nama_lengkap')->whereId($data['siswa_id'])->get();
        // $ps = Siswa::select('poin')->whereId($data['id'])->get();

        // dd($ps[0]->poin);
        // $poin_siswa = $ps[0]->poin;
        // $poin_sp = $sp->poin;
        // $nama_siswa = $ns[0]->nama_lengkap;
        
        // dd($ps[0]->poin);

        // $poin_siswa = $ps->select('poin'); 

        // $poin = $sp->select('poin')->orderBy('poin', 'desc')->first();

        // $poinSP = $req->query('id');
        // $suratPeringatan->when($poinSP, function($query) use ($poinSP) {
        //     return $query->where('id');
        // });

        // $suratPeringatan->select('poin')->orderBy('poin', 'desc')->first();
        // $SP = $suratPeringatan;
        // return response()->json(ApiResponse::success($SP->get()));
        // exit();
        // dd($id);

        // $poins = $req->query('id');
        // $poinSiswa->when($poins, function($query) use ($poins) {
        //     return $query->select('poin')->whereId(2);
        // });

        $ps = Siswa::select('poin')->whereId($id)->get();
        // $ps->poin;
        // dd($ps[0]->poin);

        // return response()->json(ApiResponse::success($ps->get()));

        // $pelsis = PelanggaranSiswa::select('pelanggaran')->whereId('siswa_id', $id)->get();
        // dd($pelsis);
        // exit();

        // $siswaId = $req->query('siswa_id');
        $pelanggarans->when($id, function($query) use ($id) {
            return $query->where('siswa_id', $id);
        });

        // dd($pelanggarans->get());exit();


        $persentase = ($ps[0]->poin / $SP) * 100;

        $poin_pelanggaran = collect();
        $poin_pelanggaran->push([ 'Persentase'=>$persentase, 'Pelanggaran'=>$pelanggarans->get()]);

        return response()->json(ApiResponse::success($poin_pelanggaran));
    }
}
