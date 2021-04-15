<?php

namespace App\Http\Controllers\Admin\Sekolah;

use App\User;
use Validator;
use App\Models\Semester;
use App\Models\Superadmin\Sekolah;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SemesterController extends Controller
{
	public function index(Request $request) {
		if ($request->ajax()) {
			$data = Semester::where('user_id', Auth::id())->latest()->get();
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

		// $semester = Sekolah::where('semester')
		// 					->where('id', auth()->user()->id_sekolah)
		// 					->get();
		$semester = Sekolah::where('id', auth()->user()->id_sekolah)->get();
		// dd($semester);
		// if ($semester->count() <= 0) {
		// 	$semester = false;
		// }

		return view('admin.sekolah.semester', ['semester' => $semester, 'mySekolah' => User::sekolah()]);
	}

	public function update(Request $request)
	{
		$id     		= $request->id;
		$isChecked      = $request->isChecked;
		$structure      = $request->structure;
		// dd($structure);


		$semester = Sekolah::where('id', $id)->first();
		$semester->$structure = $isChecked == 'true' ? "Ganjil":"Genap";
		// dd($semester->$structure);
		$semester->save();
	}
}
