<?php

namespace App\Http\Controllers\Superadmin\Berita;

use Validator;
use Illuminate\Http\Request;
use App\Models\Superadmin\KategoriBerita;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class KategoriBeritaController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = KategoriBerita::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" id="'.$data->id.'" class="edit btn btn-mini btn-info shadow-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" id="'.$data->id.'" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('superadmin.berita.kategori-berita');
    }

    public function store(Request $request) {
         // validasi
         $rules = [
            'kategori_berita'  => 'required|max:100',
        ];

        $message = [
            'kategori_berita.required' => 'Kolom ini gaboleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()->all()
                ]);
        }

        $suku = KategoriBerita::create([
            'name'  => $request->input('kategori_berita'),
        ]);

        return response()
            ->json([
                'success' => 'Data berhasil ditambahkan.',
            ]);
    }

    public function edit($id) {
        $kategori_berita = KategoriBerita::find($id);

        return response()
            ->json([
                'kategori_berita'  => $kategori_berita
            ]);
    }

    public function update(Request $request) {
         // validasi
         $rules = [
            'kategori_berita'  => 'required|max:100',
        ];

        $message = [
            'kategori_berita.required' => 'Kolom ini tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()->all()
                ]);
        }

        KategoriBerita::whereId($request->input('hidden_id'))->update([
            'name'  => $request->input('kategori_berita'),
        ]);

        return response()
            ->json([
                'success' => 'Data berhasil diupdate.',
            ]);
    }

    public function destroy($id) {
        $delKategori = KategoriBerita::find($id);
        $delKategori->delete();
    }
}
