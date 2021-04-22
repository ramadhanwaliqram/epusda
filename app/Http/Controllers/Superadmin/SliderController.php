<?php

namespace App\Http\Controllers\Superadmin;

use Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{   
    private $rules = [
        'judul' => ['required'],
        'start_date' => ['required'],
        'end_date' => ['required'],
        'keterangan' => ['required'],
        'foto' => ['nullable', 'mimes:jpeg,jpg,png', 'max:3000']
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Slider::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" id="'.$data->id.'" class="edit btn btn-mini btn-info shadow-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" id="'.$data->id.'" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>';
                    return $button;
                })
                ->addColumn('foto', function ($data) {
                    $btnlink = '<a target="_blank" href="'.Storage::url($data->foto).'" class="badge badge-warning">Lihat Foto</a>';
                    return $btnlink;
                })
                ->rawColumns(['foto', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        $sliders = Slider::all();
        return view('superadmin.slider', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
    *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = $req->all();
        $validator = Validator::make($data, $this->rules);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all())->withInput();
        }

        $data['foto'] = null;
        if ($req->file('foto')) {
            $data['foto'] = $req->file('foto')->store('slider', 'public');
        }

        Slider::create([
            'judul' => $data['judul'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'keterangan' => $data['keterangan'],
            'foto' => $data['foto']
        ]);

        return response()
            ->json([
                'success' => 'Data berhasil ditambahkan.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Slider::find($id);
        return response()
            ->json([
                'id'            => $data->id,
                'judul'          => $data->judul,
                'start_date'      => $data->start_date,
                'end_date'       => $data->end_date,
                'keterangan'       => $data->keterangan,
                'foto'         => $data->foto,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req) {
        $data = $req->all();

        $validator = Validator::make($data, $this->rules);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all())->withInput();
        }

        $slider = Slider::findOrFail($data['hidden_id']);
        $data['foto'] = null;
        if ($req->file('foto')) {
            $data['foto'] = $req->file('foto')->store('slider', 'public');
        }

        Slider::whereId($data['hidden_id'])->update([
            'judul' => $data['judul'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'keterangan' => $data['keterangan'],
            'foto' => $data['foto'] ?? $slider->foto
        ]);

        if ($req->file('foto') && $slider->foto && Storage::disk('public')->exists($slider->foto)) {
            Storage::disk('public')->delete($slider->foto);
        }

        return response()
            ->json([
                'success' => 'Data berhasil di update.',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        $slider->delete();
        if ($slider->foto && Storage::disk('public')->exists($slider->foto)) {
            Storage::disk('public')->delete($slider->foto);
        }
    }
}
