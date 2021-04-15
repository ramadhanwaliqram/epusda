<?php

namespace App\Http\Controllers\Guru\Fungsionaris;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Pegawai;
use App\Utils\CRUDResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Superadmin\{Provinsi, KabupatenKota, Kecamatan};
use App\Models\Admin\Access;
use App\Models\BagianPegawai;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    private const AGAMA_RULE = "Islam,Budha,Kristen Protestan,Hindu,Kristen Katolik,Konghuchu";
    private $pegawaiRules = [
        'tanggal_lahir' => ['nullable', 'date'],
        'jk' => ['nullable', 'in:Laki-Laki,Perempuan'],
        'agama' => ['nullable', 'in:' . PegawaiController::AGAMA_RULE],
        'is_menikah' => ['nullable', 'boolean'],
        'tanggal_mulai' => ['nullable', 'date'],
        'foto' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2000']
    ];

    public function index() {
        $pegawais = Pegawai::whereHas('user', function($q) {
            return $q->whereIdSekolah(auth()->user()->id_sekolah);
        })->get();

        $provinsis = Provinsi::all();
        $kabupaten = KabupatenKota::all();
        $kecamatan  = Kecamatan::all();
        $bagian = BagianPegawai::where('user_id', Auth::id())->get();
        $semester = Semester::where('user_id', Auth::id())->get();
        return view('guru.fungsionaris.pegawai', ['provinsis' => $provinsis, 'kabupaten' => $kabupaten, 'kecamatan' => $kecamatan,'pegawais' => $pegawais, 'bagian' => $bagian, 'semester' => $semester, 'mySekolah' => User::sekolah()]);
    }

    public function getKabupatenKota($id)
    {
        $kabupaten = Provinsi::find($id)->kabupatenKotas;
        return response()->json($kabupaten);
    }

    public function store(Request $req) {
        $data = $req->all();
        $validator = Validator::make($data, $this->pegawaiRules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->all())->withInput();
        }

        $validator = Validator::make($data, [
            'username' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],
            'email' => ['nullable', 'unique:users']
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->all())->withInput();
        }

        $exception = DB::transaction(function () use ($data, $req) {
            $auth = auth()->user();

            DB::beginTransaction();
            try {
                $userId = User::create([
                    'role_id' => 4,
                    'id_sekolah' => $auth['id_sekolah'],
                    'name' => $data['nama_pegawai'],
                    'username' => $data['username'],
                    'nis' => $data['nip'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password'])
                ])->id;

                $data['foto'] = null;
                if ($req->file('foto')) {
                    $data['foto'] = $req->file('foto')->store('pegawais', 'public');
                }

                $data['tanggal_lahir'] = Carbon::parse($data['tanggal_lahir'])->format('Y-m-d');
                $data['tanggal_mulai'] = Carbon::parse($data['tanggal_mulai'])->format('Y-m-d');
                $pegawai = Pegawai::create([
                    'user_id' => $userId,
                    'name' => $data['nama_pegawai'],
                    'nip' => $data['nip'],
                    'nik' => $data['nik'],
                    'gelar_depan' => $data['gelar_depan'],
                    'gelar_belakang' => $data['gelar_belakang'],
                    'tempat_lahir' => $data['tempat_lahir'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'jk' => $data['jk'],
                    'agama' => $data['agama'],
                    'is_menikah' => $data['is_menikah'],
                    'alamat_tinggal' => $data['alamat_tinggal'],
                    'provinsi_id' => $data['provinsi'],
                    'kabupaten_kota_id' => $data['kabupaten'],
                    'kecamatan_id' => $data['kecamatan'],
                    'dusun' => $data['dusun'],
                    'rt' => $data['rt'],
                    'rw' => $data['rw'],
                    'kode_pos' => $data['kode_pos'],
                    'no_telepon_rumah' => $data['no_telepon_rumah'],
                    'no_telepon' => $data['no_telepon'],
                    'tanggal_mulai' => $data['tanggal_mulai'],
                    'bagian_pegawai_id' => $data['bagian'],
                    'tahun_ajaran' => $data['tahun_ajaran'],
                    'semester_id' => $data['semester'],
                    'foto' => $data['foto']??""
                ]);

                // Insert Access
                $access = Access::create([
                    'sekolah_id'=>$auth->sekolah()->id,
                    'pegawai_id'=>$pegawai->id,
                ]);

                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                dd($e->getMessage());
                return $e->getMessage();
            }
        });

        if ($exception) {
            return redirect()->back()->withErrors($exception)->withInput();
        }

        return redirect()->back()->with(CRUDResponse::successCreate("pegawai"));
    }

    public function edit($id) {
        $pegawai = Pegawai::findOrFail($id);
        $provinsis = Provinsi::all();
        $kabupaten = KabupatenKota::all();
        $kecamatan  = Kecamatan::all();
        $bagian = BagianPegawai::where('user_id', Auth::id())->get();
        $semester = Semester::where('user_id', Auth::id())->get();

        return view('guru.fungsionaris.pegawai_edit', ['pegawai' => $pegawai, 'mySekolah' => User::sekolah(), 'provinsis' => $provinsis, 'kabupaten' => $kabupaten, 'kecamatan' => $kecamatan, 'bagian' => $bagian, 'semester' => $semester]);
    }

    public function update($id, Request $req) {
        $data = $req->all();

        $validator = Validator::make($data, $this->pegawaiRules);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all())->withInput();
        }

        $pegawai = Pegawai::findOrFail($id);
        $currFoto = $pegawai->foto;
        $data['foto'] = $pegawai->foto;
        $data['name'] = $data['nama_pegawai'];
        if ($req->file('foto')) {
            $data['foto'] = $req->file('foto')->store('pegawais', 'public');
        } else {
            $currFoto = null;
        }

        $pegawai->update([
            'name' => $data['nama_pegawai'],
            'nip' => $data['nip'],
            'nik' => $data['nik'],
            'gelar_depan' => $data['gelar_depan'],
            'gelar_belakang' => $data['gelar_belakang'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jk' => $data['jk'],
            'agama' => $data['agama'],
            'is_menikah' => $data['is_menikah'],
            'alamat_tinggal' => $data['alamat_tinggal'],
            'provinsi_id' => $data['provinsi'],
            'kabupaten_kota_id' => $data['kabupaten'],
            'kecamatan_id' => $data['kecamatan'],
            'dusun' => $data['dusun'],
            'rt' => $data['rt'],
            'rw' => $data['rw'],
            'kode_pos' => $data['kode_pos'],
            'no_telepon_rumah' => $data['no_telepon_rumah'],
            'no_telepon' => $data['no_telepon'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'bagian_pegawai_id' => $data['bagian'],
            'tahun_ajaran' => $data['tahun_ajaran'],
            'semester_id' => $data['semester'],
            'foto' => $data['foto']
        ]);

        if ($req->file('foto') && $currFoto && Storage::disk('public')->exists($currFoto)) {
            Storage::disk('public')->delete($currFoto);
        }

        return redirect()->route('guru.fungsionaris.pegawai.index')->with(CRUDResponse::successUpdate("pegawai " . $pegawai->name));
    }

    public function destroy($id) {
        $pegawai = Pegawai::findOrFail($id);
        $access = $pegawai->access->delete();
        $pegawai->delete();

        if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        return redirect()->back()->with(CRUDResponse::successDelete("pegawai"));
    }
}
