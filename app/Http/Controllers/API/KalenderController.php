<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\Admin\Kalender;
use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Utils\ApiResponse;
use DateTime;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index($id, Request $request)
    {
        $event = [];
        $pelajaran = [];
        $d    = new DateTime($request->tanggal);
        $day = $d->format('l');
        if ($day == "Sunday") {
            $day = "Minggu";
        } else if ($day == "Monday") {
            $day = "senin";
        } else if ($day == "Tuesday") {
            $day = "selasa";
        } else if ($day == "Wednesday") {
            $day = "rabu";
        } else if ($day == "Thursday") {
            $day = "kamis";
        } else if ($day == "Friday") {
            $day = "jumat";
        } else if ($day == "Saturday") {
            $day = "sabtu";
        }
        $data = JadwalPelajaran::select('jadwal_pelajarans.id', 'kelas_id', 'jam_pelajaran', 'nama_pelajaran AS nama', 'jam_mulai', 'jam_selesai', 'kode_pelajaran')
            ->join('mata_pelajarans', 'jadwal_pelajarans.mata_pelajaran_id', 'mata_pelajarans.id')
            ->join('jam_pelajarans', 'jadwal_pelajarans.jam_pelajaran', 'jam_pelajarans.jam_ke')
            ->where('mata_pelajarans.sekolah_id', $id)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->where('semester', $request->semester)
            ->where('jadwal_pelajarans.hari', $day)
            ->orderBy('jam_pelajaran')
            ->get();
        if ($request->has('kelas_id')) {
            $kelasId = $request->kelas_id;
            $data = array_filter($data->toArray(), function ($japel) use ($kelasId) {
                return $japel['kelas_id'] == $kelasId;
            });
        }
        $kalender = Kalender::select('id', 'title AS nama', 'start_date', 'end_date', 'start_clock AS jam_mulai', 'end_clock AS jam_selesai')
            ->where('sekolah_id', "=", $id)
            ->whereBetween('start_date', [$request->tanggal_mulai, $request->tanggal_akhir])
            // ->whereRaw('? between start_date and end_date', [$request->tanggal_mulai])
            ->orderBy('start_date')->get();

        // $event = [];
        // $kalender = [];

        // if ($kalender->count() <= 0) {
        //     $event = [];
        //     $message = 'Data not found !';
        // } else {
        //     foreach ($kalender as $kal) {
        //         $event[] = [
        //             'id' => $kal->id ?? null,
        //             'title' => $kal->title ?? null,
        //             'tanggal_mulai' => $kal->start_date ?? null,
        //             'tanggal_selesai' => $kal->end_date ?? null,
        //             'jam_mulai' => $kal->start_clock ?? null,
        //             'jam_selesai' => $kal->end_clock ?? null,
        //         ];
        //     }
        // }

        // if ($data->count() <= 0) {
        //     $pelajaran = [];
        //     $message = 'Data not found !';
        // } else {
        //     foreach ($data[$day] as $d) {
        //         $pelajaran[] = [
        //             // 'id' => $d->id ?? null,
        //             'jam_pelajaran' => $d->jam_pelajaran ?? null,
        //             'nama_pelajaran' => $d->nama_pelajaran ?? null,
        //             'jam_mulai' => $d->jam_mulai ?? null,
        //             'jam_selesai' => $d->jam_selesai ?? null,
        //             'kode_pelajaran' => $d->kode_pelajaran ?? null,
        //         ];
        //     }
        //     $message = 'Success get Data';
        // }
        $events = [];
        $data = (object) $data;
        foreach ($data as $k => $v) {
            $events[] = $kalender->$k = $v;
        }
        foreach ($kalender as $k => $v) {
            $events[] = $data->$k = $v;
        }

        
        // uasort($events, function($a, $b) {
        //     if($a['jam_mulai'] == $b['jam_mulai']) {
        //         return 0;
        //     }
        //     return ($a['jam_mulai'] < $b['jam_mulai']) ? -1 : 1;
        // });

        
        return response()->json(ApiResponse::success($events));
    }
}
