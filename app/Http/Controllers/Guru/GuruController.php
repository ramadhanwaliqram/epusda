<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index() {
    	// dd(auth()->user()->pegawai->access->kalender);
        return view('guru.index');
    }
}
