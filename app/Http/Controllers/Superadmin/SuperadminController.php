<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function index() {
        $ebook = '100';
        $videobook = '100';
        $audiobook = '100';
        return view('superadmin.index', [
            'ebook' => $ebook,
            'videobook' => $videobook,
            'audiobook' => $audiobook
        ]);
    }
}
