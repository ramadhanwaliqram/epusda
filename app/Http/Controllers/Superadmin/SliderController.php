<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Superadmin\{KabupatenKota, Sekolah, Slider};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Utils\CRUDResponse;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    private $rules = [
        'judul' => ['required'],
        'kabupaten_kota' => ['required'],
        'start_date' => ['required'],
        'end_date' => ['required'],
        'keterangan' => ['required'],
        'foto' => ['nullable', 'mimes:jpeg,jpg,png', 'max:3000']
    ];

    public function index(Request $request)
    {
        $cities = KabupatenKota::all();
        // $sliders = Slider::whereDate('start_date', '<=', Carbon::now()->toDateString())
        //               ->whereDate('end_date', '>=', Carbon::now()->toDateString())->get();
        $sliders = Slider::all();
        return view('superadmin.slider', compact(['cities', 'sliders']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'         => 'required',
            'kabupaten_kota' => 'required',
            'sekolah'       => 'required',
            'keterangan'    => 'required',
            'start_date'    => 'required',
            'end_date'      => 'required',
            'foto'          => 'required|file|max:3072',
        ]);

        $fileExtension = $request->foto->getClientOriginalExtension();
        $fileName = Str::slug($request->judul . "-" . date("Y-m-d-H-i-s"), '-') . "." . $fileExtension;
        $request->foto->storeAs('public/slider', $fileName);

        $slider = Slider::create([
            'judul'             => $request->judul,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'keterangan'        => $request->keterangan,
            'start_date'        => date("Y-m-d", strtotime($request->start_date)),
            'end_date'          => date("Y-m-d", strtotime($request->end_date)),
            'foto'              => "slider/" . $fileName
        ]);

        foreach ($request->sekolah as $sekolah) {
            $slider->sekolah()->attach($sekolah);
        }

        return response()->json(\App\Utils\ApiResponse::success(""));
    }


    public function edit($id)
    {
        $cities = KabupatenKota::all();
        $slider = Slider::select('kabupaten_kotas.name', 'sliders.*')->where('sliders.id', $id)->join('kabupaten_kotas', 'sliders.kabupaten_kota_id', 'kabupaten_kotas.id')->get();
        return view('superadmin.slider-edit', [
            'slider' => $slider[0],
            'cities' => $cities
        ]);
    }

    public function update($id, Request $req)
    {
        $data = $req->all();

        $validator = Validator::make($data, $this->rules);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all())->withInput();
        }

        $slider = Slider::findOrFail($id);
        $data['foto'] = null;
        if ($req->file('foto')) {
            $data['foto'] = $req->file('foto')->store('slider', 'public');
        }

        Slider::whereId($id)->update([
            'judul' => $data['judul'],
            'kabupaten_kota_id' => $data['kabupaten_kota'],
            'keterangan' => $data['keterangan'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'foto' => $data['foto'] ?? $slider->foto
        ]);
        $slider->sekolah()->detach();

        foreach ($req->sekolah as $sekolah) {
            $slider->sekolah()->attach($sekolah);
        }

        if ($req->file('foto') && $slider->foto && Storage::disk('public')->exists($slider->foto)) {
            Storage::disk('public')->delete($slider->foto);
        }

        return redirect()->route('superadmin.slider')->with(CRUDResponse::successUpdate("Slider"));
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);
        $slider->delete();
        if ($slider->foto && Storage::disk('public')->exists($slider->foto)) {
            Storage::disk('public')->delete($slider->foto);
        }
    }
}
