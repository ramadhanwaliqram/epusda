<?php

namespace App\Http\Controllers\Guru\Fungsionaris;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Guru;
use DataTables;
use App\Models\StatusGuru;
use Illuminate\Support\Facades\Auth;

class GuruuController extends Controller
{
    //read
    public function index(Request $request) {
        if ($request->ajax()) {
            // $data = Guru::latest()->get();
            $data = Guru::join('pegawais', 'gurus.pegawai_id', 'pegawais.id')
                ->join('status_gurus', 'gurus.status_guru_id', 'status_gurus.id')
                ->where('gurus.user_id', Auth::id())
                // ->first(['gurus.*', 'pegawais.name AS nama_pegawai', 'status_gurus.name AS nama_status'])
                ->get(['gurus.*', 'pegawais.name AS nama_pegawai', 'status_gurus.name AS nama_status']);
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" data-id="' . $data->id . '" class="btn-edit btn btn-mini btn-info shadow-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" data-id="' . $data->id . '" class="btn-delete btn btn-mini btn-danger shadow-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        // $pegawai = Pegawai::where('user_id', Auth::id())->latest()->get();
        $user = User::sekolah();
        $pegawai = Pegawai::join('users', 'pegawais.user_id', 'users.id')
            ->where('users.id_sekolah', $user->id)
            ->get(['pegawais.*']);
        $status = StatusGuru::where('user_id', Auth::id())->latest()->get();
        // return($pegawai);

        return view('guru.fungsionaris.guru',['pegawai' => $pegawai, 'status' => $status, 'mySekolah' => User::sekolah()]);
    }

    public function write(Request $request) {
        if($request->req == 'write') {

            $this->validate($request, [
                'pegawai_id' => "required",
                // isi validasi
            ]);

            $obj = Guru::find($request->id);
            // dd($obj);
            if(!$obj) {
                $obj = new Guru();
            }

            $obj->user_id = Auth::id();
            $obj->pegawai_id = $request->pegawai_id;
            $obj->status_guru_id = $request->status_guru_id;
            $obj->keterangan = $request->keterangan;
            $obj->status = $request->status;
            $obj->save();

            return response()->json(true);
        }

        elseif($request->req == 'delete') {
            $obj = Guru::find($request->id);
            $obj->delete();
            return response()->json(true);
        }
    }

    public function edit($id) {
        $guru = Guru::find($id);
        // dd($guru);

        // return view('admin.fungsionaris.pegawai_edit', ['pegawai' => $pegawai, 'mySekolah' => User::sekolah(), 'provinsis' => $provinsis, 'kabupaten' => $kabupaten, 'kecamatan' => $kecamatan, 'bagian' => $bagian, 'semester' => $semester]);
        return response()->json([
            'guru'  => $guru,
        ]);
    }
}
