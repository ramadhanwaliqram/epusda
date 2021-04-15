<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Pesan;
use App\Utils\ApiResponse;
use App\User;
use Illuminate\Support\Facades\Auth;


class PengumumanAPIController extends Controller
{
    public function getPesan($sekolah_id)
    {
        $pesan = Pesan::join('users', 'users.id', 'pesans.user_id')
        				->where('id_sekolah', $sekolah_id)
        				->get('pesans.*');


        return response()->json(ApiResponse::success($pesan, 'Pengambilan data berhasil'));
    }
}
