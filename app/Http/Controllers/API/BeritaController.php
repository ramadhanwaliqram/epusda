<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Superadmin\Berita;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{

    public function index(Request $req) {
        $data = $req->all();

        // $validator = Validator::make($data, [
        //     'order_by' => 'required'
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(ApiResponse::validationError($validator->errors()));
        // }

        $berita = Berita::query();
        
        // $sekolahId = $req->query('sekolah_id');
        // $libraries->when($sekolahId, function($query) use ($sekolahId) {
        //     return $query->where('sekolah_id', $sekolahId)
        //         ->orWhereNull('sekolah_id');
        // });

        $q = $req->query('q');
        $berita->when($q, function($query) use ($q) {
            return $query->whereRaw("name LIKE '%" . strtolower($q) . "%'");
        });

        // $orderBy = $data['order_by'];
        // switch ($orderBy) {
        //     case "popular":
        //         $libraries = $libraries->orderByDesc('viewed')
        //             ->orderBy('name')
        //             ->limit(30);
        //         break;
        //     default:
        //         $libraries = $libraries;
        // }

        $berita = $berita->orderBy('tanggal_rilis', 'desc')->limit(30)->get();
        return response()->json(ApiResponse::success($berita));
    }
}
