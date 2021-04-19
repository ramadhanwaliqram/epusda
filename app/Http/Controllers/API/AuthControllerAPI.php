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

        $fieldType = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'no_phone';
        // dd($fieldType);

        if (!Auth::attempt([$fieldType => $data['email'], 'password' => $data['password']])) {
            return response()->json(ApiResponse::error('email dan password tidak ditemukan/sesuai'));
        }

        $user = Auth::user();

        return response()->json(ApiResponse::success($user));
    }

}
