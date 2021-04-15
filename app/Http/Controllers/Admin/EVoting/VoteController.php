<?php

namespace App\Http\Controllers\Admin\EVoting;

use Validator;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Models\Admin\Pemilihan;
use App\Models\Admin\Voting;

class VoteController extends Controller
{
    public function index(Request $request) {
        $names = Pemilihan::orderBy('start_date')->where('sekolah_id', auth()->user()->id_sekolah)->get();
        $pemilihans = Pemilihan::orderBy('id')->where('sekolah_id', auth()->user()->id_sekolah)->get();
        $counts = collect();
        // dd($names[0]->votes);

        foreach($names as $nc){
            foreach ($nc->calons as $calon){
                $hasil = Voting::where(['pemilihan_id'=>$nc->id, 'calon_id' => $calon->id])->count();
                $counts->push($hasil);
            }
        }
        // exit;
        return view('admin.e-voting.vote', ['names' => $names, 'pemilihans' =>$pemilihans, 'counts'=>$counts,'mySekolah' => User::sekolah()]);
    } 
     
    public function store(Request $request) {
        // validasi
        $rules = [
            'calon_id'  => 'required|max:50',
        ];

        $message = [
            'calon_id.required' => 'Kolom ini tidak boleh kosong',
        ];

        $validator = Voting::make($request->all(), $rules, $message);
        dd($request->all());
        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()->all()
                ]);
        }

        $status = Voting::create([
            'calon_id'  => $request->input('calon_id'),
            'id_user'  => auth()->user()->id
        ]);

        return response()
            ->json([
                'success' => 'Data Added.',
            ]);
    }

}