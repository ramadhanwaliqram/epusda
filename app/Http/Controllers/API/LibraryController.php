<?php

namespace App\Http\Controllers\API;

use App\Models\Borrow;
use App\Http\Controllers\Controller;
use App\Models\UserLibraryLike;
use Illuminate\Http\Request;
use App\Utils\ApiResponse;

class LibraryController extends Controller
{
    public function getBorrow($id, Request $request)
    {
        if ($request->library_id) {
            $borrow = Borrow::where([
                'user_id' => $id,
                'library_id' => $request->library_id
            ])->get();
        } else {
            $borrow = Borrow::where([
                'user_id' => $id
            ])->get();
        }
        return response()->json(ApiResponse::success($borrow));
    }

    public function addBorrow($id, Request $request)
    {
        $borrow  = Borrow::where([
            ['user_id', $id],
            ['library_id', $request->library_id]
        ])->first();

        if (!$borrow) {
            $data = Borrow::create([
                'user_id' => $id,
                'library_id' => $request->library_id,
                'ebook_expired_at' => $request->ebook_expired_at,
                'audio_expired_at' => $request->audio_expired_at,
                'video_expired_at' => $request->video_expired_at,
                'total_of_borrow' => 1
            ]);
            return response()->json(ApiResponse::success($data, "Peminjaman Berhasil"));
        } else {
            $borrow->update([
                'ebook_expired_at' => $request->ebook_expired_at,
                'audio_expired_at' => $request->audio_expired_at,
                'video_expired_at' => $request->video_expired_at,
                'total_of_borrow' => $borrow->total_of_borrow + 1
            ]);
            
            return response()->json(ApiResponse::success($borrow, "Peminjaman Berhasil"));
        }
    }

    public function like($id, Request $request)
    {
        $data = $request->all();
        $data['is_like'] = ($data['is_like'] == 'true');
        $like = UserLibraryLike::where([
            ['user_id', $data['user_id']],
            ['library_id', $id]
        ])->first();

        if ($like && !$data['is_like']) {
            $like->delete();
        } else if (!$like && $data['is_like']) {
            UserLibraryLike::create([
                'user_id' => $data['user_id'],
                'library_id' => $id
            ]);
        }

        return response()->json(ApiResponse::success([]));
    }
}
