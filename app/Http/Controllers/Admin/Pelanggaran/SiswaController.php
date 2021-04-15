<?php

namespace App\Http\Controllers\Admin\Pelanggaran;

use Validator;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Admin\PelanggaranSiswa;
use App\Models\Siswa;
use App\Models\Admin\Pelanggaran;
use App\Models\Admin\Sanksi;

class SiswaController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = PelanggaranSiswa::join('siswas', 'siswas.id', 'pelanggaran_siswas.siswa_id')
                                    ->join('users', 'users.siswa_id', 'siswas.id')
                                    ->where('users.id_sekolah', auth()->user()->id_sekolah)
                                    ->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" id="'.$data->id.'" class="edit btn btn-mini btn-info shadow-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" id="'.$data->id.'" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        $kategori = Pelanggaran::where('sekolah_id', auth()->user()->id_sekolah)->get();
        $sanksi = Sanksi::where('sekolah_id', auth()->user()->id_sekolah)->get();
        $namaSiswa = Siswa::join('users', 'users.siswa_id', 'siswas.id')
                            ->where('id_sekolah', auth()->user()->id_sekolah)
                            ->get('siswas.*');
        // dd($namaSiswa);
        return view('admin.pelanggaran.siswa', ['kategori' => $kategori, 'sanksi' => $sanksi, 'namaSiswa' => $namaSiswa, 'mySekolah' => User::sekolah()]);
    }

    public function store(Request $request) {
        // validasi
        $rules = [
            'siswa_id'  => 'required|max:50',
        ];

        $message = [
            'siswa_id.required' => 'Kolom ini tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()->all()
                ]);
        }
        $siswa = Siswa::find($request->input('siswa_id'));
        $siswa->poin += $request->input('poin');
        $siswa->save();

        $status = PelanggaranSiswa::create([
            'siswa_id' => $request->input('siswa_id'),
            'nama_siswa' => $siswa->nama_lengkap,
            'tanggal_pelanggaran' => $request->input('tanggal_pelanggaran'),
            'pelanggaran' => $request->input('pelanggaran'),
            'poin' => $request->input('poin'),
            'sebab' => $request->input('sebab'),
            'sanksi' => $request->input('sanksi'),
            'penanganan' => $request->input('penanganan'),
            'keterangan' => $request->input('keterangan')
        ]);


        return response()
            ->json([
                'success' => 'Data Added.',
            ]);
    }

    public function edit($id) {
        $siswa_id = PelanggaranSiswa::find($id);
        $nama_siswa = PelanggaranSiswa::find($id);
        $tanggal_pelanggaran = PelanggaranSiswa::find($id);
        $pelanggaran = PelanggaranSiswa::find($id);
        $poin = PelanggaranSiswa::find($id);
        $sebab = PelanggaranSiswa::find($id);
        $sanksi = PelanggaranSiswa::find($id);
        $penanganan = PelanggaranSiswa::find($id);
        $keterangan = PelanggaranSiswa::find($id);

        return response()
            ->json([
                'siswa_id'  => $siswa_id,
                'nama_siswa'  => $nama_siswa,
                'tanggal_pelanggaran'  => $tanggal_pelanggaran,
                'pelanggaran'  => $pelanggaran,
                'poin'  => $poin,
                'sebab'  => $sebab,
                'sanksi'  => $sanksi,
                'penanganan'  => $penanganan,
                'keterangan'  => $keterangan
            ]);
        }

    public function update(Request $request) {
        // validasi
        $rules = [
            'siswa_id'  => 'required|max:50',
        ];

        $message = [
            'siswa_id.required' => 'Kolom ini tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()->all()
                ]);
        }

        $siswa = Siswa::find($request->input('siswa_id'));
        $siswa->poin -= $request->input('poin_lama');
        $siswa->poin += $request->input('poin');

        $siswa->save();
        $status = PelanggaranSiswa::whereId($request->input('hidden_id'))->update([
            'siswa_id'              => $request->input('siswa_id'),
            'nama_siswa'            => $siswa->nama_lengkap,
            'tanggal_pelanggaran'   => $request->input('tanggal_pelanggaran'),
            'pelanggaran'           => $request->input('pelanggaran'),
            'poin'                  => $request->input('poin'),
            'sebab'                 => $request->input('sebab'),
            'sanksi'                => $request->input('sanksi'),
            'penanganan'            => $request->input('penanganan'),
            'keterangan'            => $request->input('keterangan')
        ]);

        return response()
            ->json([
                'success' => 'Data Updated.',
            ]);
    }

    public function destroy($id) {
        $pelanggaran = PelanggaranSiswa::find($id);
        $siswa = Siswa::whereId($pelanggaran->siswa_id)->first();
        $siswa->poin -= $pelanggaran->poin;
        $siswa->save();
        $pelanggaran->delete();
    }

}
