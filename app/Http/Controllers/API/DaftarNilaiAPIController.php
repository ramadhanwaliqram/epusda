<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin\DaftarNilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Utils\ApiResponse;

class DaftarNilaiAPIController extends Controller
{
    public function nilaiSiswa($id, Request $req)
    {
        $data = $req->all();
        
        $nilais = DaftarNilai::query()->with(['siswa', 'mataPelajaran'])->where('siswa_id', $id);
        $nilais = $this->filterNilai($nilais, $req);
        
        return response()->json(ApiResponse::success(
            $nilais->orderBy('kategori_nilai')
                ->orderBy('urutan_nilai')
                ->get()
            )
        );
    }

    public function nilaiGuru($id, Request $req)
    {
        $nilais = DaftarNilai::with(['siswa', 'mataPelajaran'])
            ->whereHas('mataPelajaran', function($q) use ($id) {
                $q->where('guru_id', $id);
            });
        $nilais = $this->filterNilai($nilais, $req);

        return response()->json(ApiResponse::success(
            $nilais->orderBy('kategori_nilai')
                ->orderBy('urutan_nilai')
                ->get()
            )
        );
    }
    
    private function filterNilai($nilais, $req) {
        $ta = $req->query('tahun_ajaran');
        $semester = $req->query('semester');
        
        $nilais->when($ta, function($q) use ($ta) {
            return $q->where('tahun_ajaran', $ta); 
        });
        
        $nilais->when($semester, function($q) use ($semester) {
            return $q->where('semester', $semester); 
        });
        
        return $nilais;
    }
}