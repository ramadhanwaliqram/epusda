<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Utils\ApiResponse;

class SliderControllerAPI extends Controller
{
    public function index()
    {
    	$slider    = Slider::latest()->get();
    	return response()->json(ApiResponse::success($slider));
    }
}
