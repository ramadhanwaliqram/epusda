<?php

namespace App\Http\Controllers\Admin\Pelajaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{JadwalPelajaran, JamPelajaran, MataPelajaran, TingkatanKelas, Semester};
use App\Models\Admin\Kelas;
use App\User;

class JadwalPelajaranController extends Controller
{

    public function index(Request $request) {
        $data = null;

        if($request->req == 'table') {
            $data = JadwalPelajaran::with('mataPelajaran')
                                   ->where('tahun_ajaran', $request->tahun_ajaran)
                                   ->where('kelas_id', $request->kelas_id)
                                   ->orderBy('jam_pelajaran')
                                   ->get();

                                   $data = $data->groupBy('hari');

        }

        // if($request->req == 'table') {
        //     $data = JadwalPelajaran::with('mataPelajaran')
        //                            ->where('tahun_ajaran', $request->tahun_ajaran)
        //                            ->where('kelas_id', $request->kelas_id)
        //                            ->where('semester', $request->semester)
        //                            ->orderBy('jam_pelajaran')
        //                            ->get();

        //                            $data = $data->groupBy('hari');

        // }

        elseif($request->req == 'single') {
            $obj = JadwalPelajaran::findOrFail($request->id);
            return response()->json($obj);
        }

        $jam_pelajaran = [
            ['id' => '-', 'label' => '(07:30 - 08:00)' ],
            ['id' => '1', 'label' => '(08:00 - 08:45)' ],
            ['id' => '2', 'label' => '(08:45 - 09:30)' ],
            ['id' => '3', 'label' => '(09:30 - 10:15)' ],
            ['id' => '-', 'label' => '(10:15 - 10:30)' ],
            ['id' => '4', 'label' => '(10:30 - 11:15)' ],
            ['id' => '5', 'label' => '(11:15 - 12:00)' ],
            ['id' => '-', 'label' => '(12:00 - 12:15)' ],
            ['id' => '6', 'label' => '(12:15 - 13:00)' ],
            ['id' => '7', 'label' => '(13:00 - 13:45)' ],
            ['id' => '-', 'label' => '(13:45 - 14:00)' ],
            ['id' => '8', 'label' => '(14:00 - 14:45)' ],
            ['id' => '9', 'label' => '(14:45 - 15:30)' ],
        ];

        $kelas = Kelas::where('user_id', $request->user()->id)->get();

        $tahun_ajaran = [
            '2018/2019',
            '2019/2020',
            '2020/2021',
            '2021/2022',
            '2022/2023',
            '2023/2024',
            '2024/2025',
            '2025/2026',
            '2026/2027',
            '2027/2028',
        ];
        // $semesters = Semester::where('user_id', auth()->user()->id)->get();
        // dd($data);

        $pelajaran = MataPelajaran::join('gurus', 'gurus.id', 'guru_id')
                                    ->join('pegawais', 'pegawais.id', 'gurus.pegawai_id')
                                    ->where('sekolah_id', $request->user()->id_sekolah)
                                    ->selectRaw('mata_pelajarans.id, concat(nama_pelajaran, " | ", name) as name')->get();

        return view('admin.pelajaran.jadwal-pelajaran', compact('jam_pelajaran', 'kelas', 'tahun_ajaran', 'data', 'pelajaran'), ['mySekolah' => User::sekolah()]);
    }

    public function getJamPelajaran(Request $request)
    {
        $jam_pelajarans = JamPelajaran::where([
            'sekolah_id'=>auth()->user()->sekolah()->id,
            'hari'=>$request->hari
        ])->orderBy('jam_mulai')->get();
        $rowCount=0;
        $html = NULL;
        foreach($jam_pelajarans->chunk(6) as $key=>$chunk_jp){
            $html.='<div class="col-sm-6">';
            foreach($chunk_jp as $jp){
                $html .= '
                  <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="jam_pelajaran[]" value="'.$jp->id.'">
                        '.$jp->jam_ke.' '.date("H:i", strtotime($jp->jam_mulai)).' - '.date("H:i", strtotime($jp->jam_selesai)).'
                    </label>
                  </div>';
            }
            $html.='</div>';
        }
        echo $html;
    }

    public function getJadwalPelajaran(Request $request)
    {
        $kelas = $request->kelas;
        $semester = $request->semester;
        $tahun_ajaran = $request->tahun_ajaran;
    }

    public function write(Request $request) {

        if($request->req == 'write') {
            foreach($request->jam_pelajaran as $jam_pelajaran){
                $obj = JadwalPelajaran::find($request->id);
                if(!$obj) {
                    $obj = new JadwalPelajaran();
                }
                $obj->kelas_id = $request->kelas_id;
                $obj->mata_pelajaran_id = $request->mata_pelajaran_id;
                $obj->hari = $request->hari;
                $obj->semester = $request->semester;
                $obj->tahun_ajaran = $request->tahun_ajaran;
                $obj->jam_pelajaran = $jam_pelajaran;
                $obj->keterangan = $request->keterangan;
                $obj->save();
            }
            return response()->json($obj);
        }
        elseif($request->req == 'delete') {
            $obj = JadwalPelajaran::findOrfail($request->id);
            return response()->json($obj->delete());
        }
    }
}
