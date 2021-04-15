<?php

namespace App\Http\Controllers\Admin\DaftarNilai;

use App\User;
use App\Models\Siswa;
use App\Models\Semester;
use App\Models\Admin\Kelas;
use App\Models\Admin\DaftarNilai;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\TingkatanKelas;
use App\Http\Controllers\Controller;
use App\Utils\CRUDResponse;
use Illuminate\Support\Facades\Auth;

class DaftarNilaiController extends Controller
{
    public function index(Request $request)
    {
        $a = 0;
        $nilai = [];
        $data = [];
        $def_uni = 1;
        $jumlah_data = 1;
        $data_siswa = [];
        $data_pelajaran = NULL;
        $kelas = Kelas::where('user_id', auth()->id())->get();
        // $semester = Semester::where('user_id', auth()->user()->id)->get();

        $pelajaran = MataPelajaran::join('gurus', 'gurus.id', 'guru_id')
            ->join('pegawais', 'pegawais.id', 'gurus.pegawai_id')
            ->where('sekolah_id', auth()->user()->id_sekolah)
            ->selectRaw('mata_pelajarans.id, concat(nama_pelajaran, " | ", name) as name')->get();
        if ($request->req == 'table') {
            if ($request->kelas_id && $request->mata_pelajaran_id && $request->tahun_ajaran && $request->semester && $request->kategori_nilai) {
                $siswas = Siswa::where(['kelas_id' => $request->kelas_id])->orderBy('nama_lengkap', 'ASC');

                if ($siswas->count() > 0) {
                    foreach ($siswas->get() as $siswa) {
                        $id_siswa = $siswa->id;
                        $daftarNilai = DaftarNilai::where(['kelas_id' => $request->kelas_id, 'siswa_id' => $id_siswa, 'mata_pelajaran_id' => $request->mata_pelajaran_id, 'semester' => $request->semester, 'tahun_ajaran' => $request->tahun_ajaran, 'kategori_nilai' => $request->kategori_nilai, 'urutan_nilai' => '1']);
                        if ($daftarNilai->count() == 0) {
                            $nilai = new DaftarNilai;
                            $nilai->kelas_id = $request->kelas_id;
                            $nilai->siswa_id = $siswa->id;
                            $nilai->mata_pelajaran_id = $request->mata_pelajaran_id;
                            $nilai->semester = $request->semester;
                            $nilai->tahun_ajaran = $request->tahun_ajaran;
                            $nilai->kategori_nilai = $request->kategori_nilai;
                            $nilai->nilai = 0;
                            $nilai->urutan_nilai = 1;
                            $nilai->save();
                        }
                    }
                } else {
                    $id_siswa = 0;
                }

                $data_siswa = $siswas->get();
                $jumlah_data = DaftarNilai::where([
                    'kelas_id' => $request->kelas_id,
                    'siswa_id' => $id_siswa,
                    'mata_pelajaran_id' => $request->mata_pelajaran_id,
                    'semester' => $request->semester,
                    'tahun_ajaran' => $request->tahun_ajaran,
                    'kategori_nilai' => $request->kategori_nilai
                ])->count();
                $data_pelajaran = MataPelajaran::findOrFail($request->mata_pelajaran_id);
            }
            // $jumlah_data = DaftarNilai::selectRaw('urutan_nilai')->count();
            // if ($jumlah_data < 1) {
            //     $jumlah_data = 1;
            // }

            // $def_uni = 1;
            // dd($jumlah_data);

            // $data = Siswa::with(['kelas'])
            //                  ->where('kelas_id', $request->kelas_id)
            //                  ->orderBy('nama_lengkap')
            //                  ->get();
            // return response()->json($data);
            // foreach ($data as $dt) {
            //     $nilai[] = DaftarNilai::whereNotNull('nilai')->where('siswa_id', $dt->id)->get();
            // }

            // $semester = Semester::whereId('user_id', auth()->user()->id)->orderBy('name')->get();


            // $pelajaran = MataPelajaran::join('gurus', 'gurus.id', 'guru_id')
            //             ->join('pegawais', 'pegawais.id', 'gurus.pegawai_id')
            //             ->where('sekolah_id', auth()->user()->id_sekolah)
            //             ->selectRaw('mata_pelajarans.guru_id, concat(name) as nama_guru')
            //             ->selectRaw('mata_pelajarans.id, concat(nama_pelajaran) as name')->get();
        }
        return view(
            'admin.daftar-nilai',
            compact(
                'a',
                'nilai',
                'data_siswa',
                'jumlah_data',
                'data_pelajaran',
                'pelajaran',
                'kelas',
                'data',
            ),
            [
                'mySekolah' => User::sekolah()
            ]
        );
    }

    public function store(Request $request)
    {
        $kelas_id = $request->kelas_id;
        $mata_pelajaran_id = $request->mata_pelajaran_id;
        $semester = $request->semester;
        $tahun_ajaran = $request->tahun_ajaran;
        $kategori_nilai = $request->kategori_nilai;
        $urutan_nilai = $request->urutan_nilai;

        $data_siswa = Siswa::where(['kelas_id' => $kelas_id])->orderBy('nama_lengkap', 'ASC');

        if ($data_siswa->count() > 0) {
            foreach ($data_siswa->get() as $siswa) {
                $id_siswa = $siswa->id;

                $daftar_nilai = DaftarNilai::where([
                    'kelas_id' => $kelas_id,
                    'siswa_id' => $id_siswa,
                    'mata_pelajaran_id' => $mata_pelajaran_id,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahun_ajaran,
                    'kategori_nilai' => $kategori_nilai,
                    'urutan_nilai' => $urutan_nilai
                ]);

                if ($daftar_nilai->count() == 0) {
                    $data = DaftarNilai::create([
                        'kelas_id'  => $kelas_id,
                        'siswa_id'  => $id_siswa,
                        'mata_pelajaran_id' => $mata_pelajaran_id,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahun_ajaran,
                        'kategori_nilai' => $kategori_nilai,
                        'nilai' => 0,
                        'urutan_nilai' => $urutan_nilai
                    ]);
                }
            }
        }
        /////////////////////////////
        return response()->json(['siswa' => $data_siswa->get()]);

        // return redirect()->route('admin.daftar-nilai')->with(CRUDResponse::successUpdate("Nilai"));
    }

    public function update(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $kelas_id = $request->kelas_id;
        $mata_pelajaran_id = $request->mata_pelajaran_id;
        $tahun_ajaran = $request->tahun_ajaran;
        $semester = $request->semester;
        $kategori_nilai = $request->kategori_nilai;
        $nilai = $request->nilai;
        $urutan_nilai = $request->urutan_nilai;

        $daftar_nilai = DaftarNilai::where([
            'kelas_id' => $kelas_id,
            'siswa_id' => $siswa_id,
            'mata_pelajaran_id' => $mata_pelajaran_id,
            'semester' => $semester,
            'tahun_ajaran' => $tahun_ajaran,
            'kategori_nilai' => $kategori_nilai,
            'urutan_nilai' => $urutan_nilai
        ])->first();

        if ($daftar_nilai->count() > 0) {
            $daftar_nilai->nilai = $nilai;
            $daftar_nilai->save();
        } else if ($daftar_nilai->count() == 0) {
            DaftarNilai::create([
                'kelas_id' => $kelas_id,
                'siswa_id' => $siswa_id,
                'mata_pelajaran_id' => $mata_pelajaran_id,
                'semester' => $semester,
                'tahun_ajaran' => $tahun_ajaran,
                'kategori_nilai' => $kategori_nilai,
                'nilai' => $nilai,
                'urutan_nilai' => $urutan_nilai
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $kelas_id = $request->kelas_id;
        $mata_pelajaran_id = $request->mata_pelajaran_id;
        $tahun_ajaran = $request->tahun_ajaran;
        $semester = $request->semester;
        $kategori_nilai = $request->kategori_nilai;
        $nilai = $request->nilai;
        $urutan_nilai = $request->urutan_nilai;

        $daftar_nilai = DaftarNilai::where([
            'kelas_id' => $kelas_id,
            'mata_pelajaran_id' => $mata_pelajaran_id,
            'semester' => $semester,
            'tahun_ajaran' => $tahun_ajaran,
            'kategori_nilai' => $kategori_nilai,
            'urutan_nilai' => $urutan_nilai
        ]);
        if ($daftar_nilai->forceDelete()) {
            $data_siswa = Siswa::where(['kelas_id' => $kelas_id])->orderBy('nama_lengkap', 'ASC');
            return response()->json(['siswa' => $data_siswa->get()]);
        }
    }
}
