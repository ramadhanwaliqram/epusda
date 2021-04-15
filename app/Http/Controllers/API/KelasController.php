<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Kelas;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{

    public function index(Request $req) {
        $data = $req->all();
        $user = User::has('kelases')->where([
            ['id_sekolah', $data['sekolah_id']],
            ['role_id', 2]
        ])->first();

        return response()->json(ApiResponse::success($user->kelases));
    }
}
