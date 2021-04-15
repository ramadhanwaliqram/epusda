<?php

namespace App\Http\Controllers\Guru\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Admin\{Kelas, Jurusan};
use App\Models\{Pegawai, Guru, TingkatanKelas};
use DataTables;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data = Guru::latest()->get();
            $data = Kelas::join('pegawais', 'kelas.pegawai_id', 'pegawais.id')
                ->join('jurusans', 'kelas.jurusan_id', 'jurusans.id')
                ->where('kelas.user_id', Auth::id())
                ->get(['kelas.*', 'pegawais.name AS wali_kelas', 'jurusans.name AS jurusan']);
            // $data = Kelas::all();
            // dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        $kelas = Kelas::join('pegawais', 'kelas.pegawai_id', 'pegawais.id')
            ->join('jurusans', 'kelas.jurusan_id', 'jurusans.id')
            ->where('kelas.user_id', Auth::id())
            ->get(['kelas.*', 'pegawais.name AS guru', 'jurusans.name AS jurusan']);
        $pegawai = Pegawai::join('gurus', 'pegawais.id', 'gurus.pegawai_id')
            ->where('pegawais.user_id', Auth::id())
            ->get();
        $gurus = Guru::where('user_id', Auth::id())->get();
        $tingkat = TingkatanKelas::where('user_id', Auth::id())->latest()->get();
        $jurusan = Jurusan::where('user_id', Auth::id())->latest()->get();

        return view('guru.sekolah.kelas',['tingkat' => $tingkat, 'jurusan' => $jurusan, 'gurus' => $gurus, 'mySekolah' => User::sekolah()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
