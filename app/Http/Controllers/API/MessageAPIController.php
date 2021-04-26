<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Utils\ApiResponse;

class MessageAPIController extends Controller
{
    public function getMessage()
    {
        $pesan = Message::latest()->get();

        return response()->json(ApiResponse::success($pesan, 'Success get data'));
    }
}
