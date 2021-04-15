<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Superadmin\Library;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class HomeController extends Controller
{
    public function index(Request $req) {
        $data = $req->all();
        $userId = $data['user_id'];
        
        $newestLibraries = Library::query()->with(['kategori', 'penulis']);

        $sekolahId = $req->query('sekolah_id');
        $newestLibraries->when($sekolahId, function($query) use ($sekolahId) {
            return $query->where('sekolah_id', $sekolahId)
                ->orWhereNull('sekolah_id');
        });
        $newestLibraries = $newestLibraries->orderByDesc('created_at')->limit(10)->get();
        
        $user = User::find($userId);
        $akses = $user->pegawai->access ?? null;
        
        $borrowedLibraries = Library::with(['kategori', 'penulis'])
            ->whereHas('pinjams', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->get();

        $data = [
            'newestLibraries' => $newestLibraries,
            'borrowedLibraries' => $borrowedLibraries,
            'akses' => $akses
        ];

        return response()->json(ApiResponse::success($data));
    }
}