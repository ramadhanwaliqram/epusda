<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthControllerAPI extends Controller
{
    public function test()
    {
        return response()->json(ApiResponse::error('error lah'));
    }

    public function loginUser(Request $req) {
        $data = $req->all();

        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(ApiResponse::validationError($validator->errors()));
        }

        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return response()->json(ApiResponse::error('email dan password tidak ditemukan/sesuai'));
        }

        $user = User::where('email', $data['email'])->first();

        return response()->json(ApiResponse::success($user));
    }

}
