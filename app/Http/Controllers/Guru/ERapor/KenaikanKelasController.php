<?php

namespace App\Http\Controllers\Guru\ERapor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class KenaikanKelasrController extends Controller
{
    public function index() {
        return view('guru.e-rapor.kenaikan-kelas', ['mySekolah' => User::sekolah()]);
    }
}
