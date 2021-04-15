<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Superadmin\Library;
use App\Models\Pinjam;
use App\Models\UserLibraryLike;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LibraryController extends Controller
{

    public function index(Request $req) {
        $data = $req->all();
        $userId = $req->query('user_id');

        $validator = Validator::make($data, [
            'order_by' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(ApiResponse::validationError($validator->errors()));
        }

        $libraries = Library::query()->with(['kategori', 'penulis']);

        $sekolahId = $req->query('sekolah_id');
        $libraries->when($sekolahId, function($query) use ($sekolahId) {
            return $query->where('sekolah_id', $sekolahId)
                ->orWhereNull('sekolah_id');
        });

        $kategoriId = $req->query('kategori_id');
        $libraries->when($kategoriId, function($query) use ($kategoriId) {
            return $query->where('kategori_id', $kategoriId);
        });

        $q = $req->query('q');
        $libraries->when($q, function($query) use ($q) {
            return $query->whereRaw("name LIKE '%" . strtolower($q) . "%'");
        });

        $filterType = $req->query('filter_type');
        $filterFunc = null;
        if ($filterType == 'ebook') {
            $filterFunc = function($query) {
                return $query->whereNotNull('link_ebook')->where('link_ebook', '!=', '');
            };
        } else if ($filterType == 'audio') {
            $filterFunc = function($query) {
                return $query->whereNotNull('link_audio')->where('link_audio', '!=', '');
            };
        } else if ($filterType == 'video') {
            $filterFunc = function($query) {
                return $query->whereNotNull('link_video')->where('link_video', '!=', '');
            };
        }

        if ($filterFunc != null) {
            $libraries->when($filterType, $filterFunc);
        }

        $skipData = ((empty($data['page']) ? 1 : $data['page']) - 1) * 30;

        $orderBy = $data['order_by'];
        if ($orderBy == "borrowed" && !empty($userId)) {
            $libraries = $libraries->whereHas('pinjams', function($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        } 

        switch ($orderBy) {
            case "popular":
                $libraries = $libraries->orderByDesc('viewed')
                    ->orderBy('name')
                    ->skip($skipData)
                    ->take(30);
                break;
            case "newest":
                $libraries = $libraries->orderByDesc('created_at')
                    ->orderBy('name')
                    ->skip($skipData)
                    ->take(30);
            default:
                $libraries = $libraries->orderBy('name')->limit(30);
        }

        if (!empty($userId)) {
            if ($orderBy == "like") {
                $libraries = $libraries->select(DB::raw("'true' AS is_liked, libraries.*"))
                    ->join('user_library_likes AS like', 'like.library_id', 'libraries.id')
                    ->where('like.user_id', $userId)
                    ->get();
            } else {
                $libraries = $libraries->get();
                foreach($libraries as $library) {
                    $library['is_liked'] = UserLibraryLike::where([
                        ['user_id', $userId],
                        ['library_id', $library->id]
                    ])->count() > 0;
                }
            }
        } else {
            $libraries = $libraries->get();
        }
        return response()->json(ApiResponse::success($libraries));
    }
    
    public function like($id, Request $req) {
        $data = $req->all();
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

    public function getPinjam($id, Request $request)
    {
        if ($request->library_id) {
            $data = Pinjam::join('users', 'pinjams.user_id', 'users.id')
                ->join('libraries', 'pinjams.library_id', 'libraries.id')
                ->where('pinjams.user_id', $id)
                ->where('pinjams.library_id', $request->library_id)
                ->get('pinjams.*');
        } else {
            $data = Pinjam::join('users', 'pinjams.user_id', 'users.id')
                ->join('libraries', 'pinjams.library_id', 'libraries.id')
                ->where('pinjams.user_id', $id)
                ->get('pinjams.*');
        }

        return response()->json(ApiResponse::success($data));
    }

    public function addPinjam($id, Request $request)
    {
        // $req = $request->all();
        // Validator::make($req, [
        //     'ebook_expired_at' => ['nullable'],
        //     'audio_expired_at' => ['nullable'],
        //     'video_expired_at' => ['nullable']
        // ]);
        // dd(Carbon::now()->format('m'));
        $pinjam  = Pinjam::where([
            ['user_id', $id],
            ['library_id', $request->library_id]
        ])->first();

        if (!$pinjam) {
            $data = Pinjam::create([
                'user_id' => $id,
                'library_id' => $request->library_id,
                'ebook_expired_at' => $request->ebook_expired_at,
                'audio_expired_at' => $request->audio_expired_at,
                'video_expired_at' => $request->video_expired_at,
                'total_pinjam' => 1
            ]);
            return response()->json(ApiResponse::success($data, "Peminjaman Berhasil"));
        } else {
            $pinjam->update([
                'ebook_expired_at' => $request->ebook_expired_at,
                'audio_expired_at' => $request->audio_expired_at,
                'video_expired_at' => $request->video_expired_at,
                'total_pinjam' => $pinjam->total_pinjam + 1
            ]);
            
            return response()->json(ApiResponse::success($pinjam, "Peminjaman Berhasil"));
        }
    }
}