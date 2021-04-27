<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class SuperadminController extends Controller
{
    public function index() {
        $ebook = '100';
        $videobook = '100';
        $audiobook = '100';
        $user = User::where('role_id', 2)->count();
        return view('superadmin.index', [
            'ebook' => $ebook,
            'videobook' => $videobook,
            'audiobook' => $audiobook,
            'user' => $user
        ]);
    }
}
