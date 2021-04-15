<?php

namespace App\Http\Controllers\Superadmin\Berita;


use Illuminate\Http\Request;
use App\Models\Superadmin\KategoriBerita;
use App\Models\Superadmin\Berita;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Utils\CRUDResponse;



class BeritaController extends Controller
{

    private $rules = [
        'judul' => ['required'],
        'kategori' => ['required'],
        'isi' => ['required'],
        'thumbnail' => ['nullable', 'mimes:jpeg,jpg,png', 'max:3000']
    ];

    public function index(Request $request){
        $data = Berita::latest()->get();
        $no = 1;
        // $i = 0;
        // foreach ($data as $berita) {
        //     $data[$i]['thumbnail'] = '<a target="_blank" href="'.Storage::url($berita->thumbnail).'">Lihat Foto</a>';
        // }
        // if ($request->ajax()) {
     //        $data = Berita::latest()->get();
     //        $i = 0;
     //        foreach ($data as $berita) {
     //            $data[$i]['thumbnail'] = '<a target="_blank" href="'.Storage::url($berita->thumbnail).'">Lihat Foto</a>';
     //        }
     //        return DataTables::of($data)
     //            ->addColumn('action', function ($data) {
     //                $button = '<button type="button" id="'.$data->id.'" class="edit btn btn-mini btn-info shadow-sm">Edit</button>';
     //                $button .= '&nbsp;&nbsp;&nbsp;<button type="button" id="'.$data->id.'" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>';
     //                return $button;
     //            })
     //            ->rawColumns(['action'])
     //            ->rawColumns(['thumbnail'])
     //            ->addIndexColumn()
     //            ->make(true);
     //    }
        $katbe = KategoriBerita::all();
        return view('superadmin.berita.berita', ['no'=>$no, 'katbe' => $katbe, 'data' =>$data]);
    }

    public function edit($id) {
        $berita = Berita::find($id);
        $katbe = KategoriBerita::all();
        return view('superadmin.berita.berita_edit', [
            'berita' => $berita, 'katbe' => $katbe
        ]);
    }

    public function store(Request $req) {

        $data = $req->all();
        $validator = Validator::make($data, $this->rules);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all())->withInput();
        }

        $data['thumbnail'] = null;
        if ($req->file('thumbnail')) {
            $data['thumbnail'] = $req->file('thumbnail')->store('berita', 'public');
        }

        Berita::create([
            'name' => $data['judul'],
            'kategori' => $data['kategori'],
            'tanggal_rilis' => $data['tanggal_rilis'],
            'isi' => $data['isi'],
            'thumbnail' => $data['thumbnail']
        ]);

        return response()
            ->json([
                'success' => 'Data berhasil ditambahkan.',
        ]);

    }

    public function update($id, Request $req) {
        $data = $req->all();

        $validator = Validator::make($data, $this->rules);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all())->withInput();
        }

        $berita = Berita::findOrFail($id);
        $data['thumbnail'] = null;
        if ($req->file('thumbnail')) {
            $data['thumbnail'] = $req->file('thumbnail')->store('berita', 'public');
        }

        Berita::whereId($id)->update([
            'name' => $data['judul'],
            'kategori' => $data['kategori'],
            'tanggal_rilis' => $data['tanggal_rilis'],
            'isi' => $data['isi'],
            'thumbnail' => $data['thumbnail'] ?? $berita->thumbnail
        ]);

        if ($req->file('thumbnail') && $berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
            Storage::disk('public')->delete($berita->thumbnail);
        }

        return redirect()->route('superadmin.berita.berita')->with(CRUDResponse::successUpdate("Berita"));
    }

    public function destroy($id) {
        $berita = Berita::find($id);
        $berita->delete();
        if ($berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
            Storage::disk('public')->delete($berita->thumbnail);
        }
    }


}
