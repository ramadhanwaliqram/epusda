<?php

namespace App\Http\Controllers\Admin\Perpustakaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Pinjam;

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = Pinjam::select('pinjams.*', 'users.name AS nama_lengkap', 'libraries.name')
            ->join('users', 'users.siswa_id', 'pinjams.user_id')
            ->join('libraries', 'libraries.id', 'pinjams.library_id')
            ->where('users.id_sekolah', auth()->user()->id_sekolah)
            ->get();


        return view('admin.perpustakaan.peminjaman', [
            'mySekolah' => User::sekolah(),
            'data' => $data
        ]);
    }
}
