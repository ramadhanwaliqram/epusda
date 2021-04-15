<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    public function read(Request $request) {
        if($request->req == 'table') {
            $data = Siswa::with(['kelas',
                                 'absensi' => function($q) use($request){
                                     $q->where('tanggal', $request->tanggal)->where('kelas_id', $request->kelas_id);
                                }])
                         ->where('kelas_id', $request->kelas_id)
                         ->orderBy('nama_lengkap')
                         ->get();

                         return ResponseFormatter::success($data);
        }

        elseif($request->req == 'rekap') {
            $req = $request->all();
            $data = Siswa::with(['kelas',
                                 'absensis' => function($q) use($request) {
                                     $q->whereRaw("tanggal BETWEEN '" . $request->tanggal_mulai . "' AND '" . $request->tanggal_selesai . "'")
                                      ->orderBy('tanggal');
                                }])
                         ->where('siswas.id', $request->siswa_id)
                         ->where('kelas_id', $request->kelas_id)
                         ->first();

             return ResponseFormatter::success($data);
        }
    }

    public function write(Request $request) {
        if($request->req == 'insert') {
            $validation = Validator::make($request->all(), [
                'tanggal' => 'required|date',
                'kelas_id' => 'required',
                'siswa_id' => 'required',
                'status' => 'required'
            ]);

            if($validation->fails()) {
                return ResponseFormatter::error($validation->messages(), 'Unprocessable Entity', 422);
            }

            $absensi = tap(Absensi::where([
                    ['kelas_id', $request->kelas_id],
                    ['tanggal', $request->tanggal],
                    ['siswa_id', $request->siswa_id]
                ]))->update(['status' => $request->status])
                    ->first();

            if ($absensi) {
                return ResponseFormatter::success($absensi);
            }


            $obj = Absensi::create([
                'kelas_id' => $request->kelas_id,
                'tanggal' => $request->tanggal,
                'siswa_id' => $request->siswa_id,
                'status' => $request->status,
                'editor_id' => $request->editor_id
            ]);

            return ResponseFormatter::success($obj);
        }

    }
}
