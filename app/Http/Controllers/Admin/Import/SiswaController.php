<?php

namespace App\Http\Controllers\Admin\Import;

use App\User;
use Session;
use App\Http\Controllers\Controller;
use App\Utils\CRUDResponse;
use Illuminate\Http\Request;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
	public function index(){
    	return view('admin.import.import-siswa', ['mySekolah' => User::sekolah()]);
	}

    public function import_excel(Request $request){
    	$data = $request->all();
    	// validasi
		$this->validate($request, [
		'file' => 'required|mimes:csv,xls,xlsx'
		]);

		// menangkap file excel
		// $file = $request->file('file');
		$data['file'] = null;
        if ($request->file('file')) {
            $data['file'] = $request->file('file')->store('file_siswa', 'public');
        }

		// membuat nama file unik
		// $nama_file = rand().$request->file('file')->getClientOriginalName();

		// upload ke folder file_siswa di dalam folder public
		// $file->move('file_siswa',$nama_file);


		// import data
		// Excel::import(new SiswaImport, public_path('/file_siswa/'.$nama_file));
		$siswa = Excel::import(new SiswaImport, storage_path('/app/public/'.$data['file']));

		// dd($siswa);
		// notifikasi dengan session
		Session::flash('sukses','Data Siswa Berhasil Diimport!');

		// alihkan halaman kembali
		return redirect()->route('admin.import.import-siswa')->with(CRUDResponse::successCreate("Data Siswa"));

    }
}
