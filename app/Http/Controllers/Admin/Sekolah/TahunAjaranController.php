<?php

namespace App\Http\Controllers\Admin\Sekolah;

use App\User;
use Validator;
use App\Models\Superadmin\Sekolah;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TahunAjaranController extends Controller
{
	public function index(Request $request) {
		if ($request->ajax()) {
            $data = Sekolah::where('id', auth()->user()->id_sekolah)->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" id="'.$data->id.'" class="edit btn btn-mini btn-info shadow-sm">Edit</button>';
                    // $button .= '&nbsp;&nbsp;&nbsp;<button type="button" id="'.$data->id.'" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

		// $tahun_ajaran = Sekolah::where('tahun_ajaran')
		// 					->where('id', auth()->user()->id_sekolah)
		// 					->get();
		$tahun_ajaran = Sekolah::where('id', auth()->user()->id_sekolah)->get();

		// dd($tahun_ajaran);

		return view('admin.sekolah.tahun-ajaran', ['tahun_ajaran' => $tahun_ajaran, 'mySekolah' => User::sekolah()]);
	}

	public function edit($id) {
        $tahun_ajaran = Sekolah::find($id);

        return response()
            ->json([
                'tahun_ajaran'  => $tahun_ajaran
            ]);
    }

	public function update(Request $request) {

        $status = Sekolah::whereId($request->input('hidden_id'))->update([
            'tahun_ajaran'  => $request->tahun_ajaran,
        ]);

        return response()
            ->json([
                'success' => 'Data Updated.',
            ]);
    }
}
