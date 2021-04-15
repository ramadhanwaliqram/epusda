<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\ApiResponse;
use App\Models\Admin\Pemilihan;
use App\Models\Admin\Posisi;
use App\Models\Admin\Voting;
use App\Models\Admin\Calon;
use App\Models\Admin\CalonPemilihan;

class VotingController extends Controller
{
    public function index(Request $req) {
        $voting = Pemilihan::query();
        $sekolahId = $req->query('sekolah_id');
        $posisi = $req->query('posisi');
        $voting->when($sekolahId, function($query) use ($sekolahId) {
            return $query->where('sekolah_id', $sekolahId);
        });
        $voting->when($posisi, function($query) use ($posisi) {
            return $query->where('posisi', $posisi);
        });
        $voting = $voting->whereRaw("CURRENT_DATE BETWEEN start_date AND end_date")->orderBy('posisi')->get();

        return response()->json(ApiResponse::success($voting));
    }

    public function hasVote(Request $req) {
        $data = $req->all();

        $hasVote = Voting::where([
            ['id_user', $data['user_id']],
            ['pemilihan_id', $data['pemilihan_id']]
        ])->count();
        return response()->json(ApiResponse::success([
            'has_vote' => ($hasVote > 0)
        ]));
    }

    public function posisiKandidat(Request $req) {
        $data = $req->all();
        $posisis = Pemilihan::query();

        $sekolahId = $req->query('sekolah_id');
        $posisis->when($sekolahId, function($query) use ($sekolahId) {
            return $query->where('sekolah_id', $sekolahId);
        });

        return response()->json(ApiResponse::success($posisis->get()));
    }

    public function calonKandidat(Request $req) {
        $data = $req->all();

        $calonPemilihan = CalonPemilihan::query();
        $pemilihanId = $req->query('pemilihan_id');
        $calonPemilihan->when($pemilihanId, function($query) use ($pemilihanId) {
            return $query->where('pemilihan_id', $pemilihanId);
        });
        $calonPemilihan = $calonPemilihan->has('calon')->get();
        $calons = [];
        foreach ($calonPemilihan as $cp) {
            $calons[] = $cp->calon;
        }
        return response()->json(ApiResponse::success($calons));
    }

    public function getHasilVoting(Request $req) {
        return response()->json(ApiResponse::success($this->hasilVoting($req)));
    }

    public function hasilVoting(Request $request){
        $data = $request->all();

        $jumlahsuara = Voting::all();
        $names = Pemilihan::whereId($data['pemilihan_id'])->get();
        // $calon = CalonPemilihan::all();
        $pemilihans = Pemilihan::orderBy('posisi')->get();
        $counts = collect();
        // dd($names[0]->votes);
        // exit();

        foreach($names as $nc){
            foreach ($nc->calons as $calon){
                $hasil = Voting::where(['pemilihan_id'=>$nc->id, 'calon_id' => $calon->id])->count();
                $counts->push(['name'=>$calon->name, 'total'=>$hasil]);
            }
            return $counts;
                // return response()->json(ApiResponse::success($counts));
        }


        // foreach ($names as $nc){
        //     // foreach($nc->calons as $calon){
        //     //     $hasil = Voting::where(['pemilihan_id'=>$nc->id, 'calon_id' => $calon->id])->count();
        //     //     $counts->push(['name' => $calon->name, 'total' => $hasil]);
        //     //     return response()->json(ApiResponse::success($counts));
        //     // }
        //         echo $nc->id;
        // }

        // foreach ($names as $calon){
        //         // $hasil = Voting::where(['pemilihan_id'=>$calon->id, 'calon_id' => $calon->id])->count();
        //         $counts->push(['name' => $calon->name]);
        //         return response()->json(ApiResponse::success($counts));
        // }
        // foreach($names as $nc){
        //     foreach ($nc->calons as $calon){
        //         $hasil = Voting::where(['pemilihan_id'=>$nc->id, 'calon_id' => $calon->id])->count();
        //         foreach($counts as $count){
        //             $counts->push($hasil);
        //         }
        //             return response()->json(ApiResponse::success($counts));
        //     }
        // }
    }

    public function store(Request $req) {
        $data = $req->all();


        Voting::create([
            'pemilihan_id' => $data['pemilihan_id'],
            'calon_id' => $data['calon_id'],
            'id_user' => $data['user_id']
        ]);

        return response()->json(ApiResponse::success($this->hasilVoting($req)));
    }
}
