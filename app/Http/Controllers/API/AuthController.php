<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Siswa;
use App\Models\Admin\Kelas;
use App\Models\Semester;
use App\Models\Superadmin\Sekolah;
use App\User;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function test()
    {
        return response()->json(ApiResponse::error('error lah'));
    }

    public function studentLogin(Request $req) {
        $data = $req->all();

        $validator = Validator::make($data, [
            'username' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(ApiResponse::validationError($validator->errors()));
        }

        if (!Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            return response()->json(ApiResponse::error('username dan password tidak ditemukan/sesuai'));
        }

        $user = User::where('username', $data['username'])->first();
        $siswa = Siswa::find($user->siswa_id);
        $kelas = Kelas::find($siswa->kelas_id);
        $sekolah = Sekolah::find($user->id_sekolah);
        $admin = User::where([
            ['role_id', 2],
            ['id_sekolah', $user->id_sekolah]
        ])->first();
        $siswa['user_id'] = $user->id;
        $siswa['kelas'] = $kelas->name;
        $siswa['semester'] = $sekolah->semester;
        $siswa['sekolah_id'] = $user->id_sekolah;
        $siswa['tahun_ajaran'] = str_replace("-", "/", $sekolah->tahun_ajaran);
        $siswa['deskripsi'] = "";

        return response()->json(ApiResponse::success($siswa));
    }

    public function schoolLogin(Request $req) {
        $data = $req->all();

        $validator = Validator::make($data, [
            'username' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(ApiResponse::validationError($validator->errors()));
        }

        if (!Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            return response()->json(ApiResponse::error('username dan password tidak ditemukan/sesuai'));
        }

        $user = User::where('username', $data['username'])->first();
        $pegawai = Pegawai::leftJoin('gurus', 'gurus.pegawai_id', 'pegawais.id')->where('pegawais.user_id', $user->id)->first(['pegawais.*', 'gurus.id AS guru_id']);
        $sekolah = Sekolah::find($user->id_sekolah);
        $admin = User::where([
            ['role_id', 2],
            ['id_sekolah', $user->id_sekolah]
        ])->first();
        $pegawai['user_id'] = $user->id;
        $pegawai['nama_lengkap'] = $pegawai['name'];
        $pegawai['semester'] = $sekolah->semester;
        $pegawai['kelas'] = '-';
        $pegawai['sekolah_id'] = $user->id_sekolah;
        $pegawai['tahun_ajaran'] = str_replace("-", "/", $sekolah->tahun_ajaran);
        $pegawai['deskripsi'] = "";

        return response()->json(ApiResponse::success($pegawai));
    }
}
