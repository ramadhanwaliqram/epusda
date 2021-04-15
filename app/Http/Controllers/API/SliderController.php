<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Superadmin\{Sekolah, Slider};
use App\Utils\ApiResponse;

class SliderController extends Controller
{
    public function index($sekolah_id)
    {
    	$sekolah    = Sekolah::findOrFail($sekolah_id);
    	return response()->json(ApiResponse::success($sekolah->sliders));
    }
}
