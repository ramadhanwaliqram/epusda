<?php

namespace App\Http\Controllers\Superadmin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Utils\CRUDResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ListUserController extends Controller
{
    public function index(Request $request) {
        // dd(User::latest()->get());
        // if ($request->ajax()) {
        //     $data = User::latest()->get();
        //     return DataTables::of($data)
        //         ->addColumn('action', function ($data) {
        //             $button = '<button type="button" id="'.$data->id.'" class="edit btn btn-mini btn-info shadow-sm">Edit</button>';
        //             $button .= '&nbsp;&nbsp;&nbsp;<button type="button" id="'.$data->id.'" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>';
        //             return $button;
        //         })
        //         ->rawColumns(['action'])
        //         ->addIndexColumn()
        //         ->make(true);
        // }

        $users = User::where('role_id', 2)->get();

        return view('superadmin.list-user', ['users' => $users]);
    }

    public function store(Request $req) {
        $data = $req->all();
        $rules = [
            'id_sekolah'    => 'required|max:100',
            'name'          => 'required|max:100',
            'alamat'        => 'required',
            'provinsi'      => 'required',
            'kabupaten'     => 'required',
            'jenjang'       => 'required',
            'tahun_ajaran'  => 'required',
            'username'      => 'required|max:100|unique:users,username',
            'password'      => 'required',
            // 'logo'          => ['nullable', 'mimes:jpeg,jpg,png,svg', 'max:2000']
        ];

        $message = [
            'id_sekolah.required' => 'Kolom ini gaboleh kosong',
        ];

        $validator = Validator::make($data, $rules, $message);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all())->withInput();
        }

        $sekolahId = User::create([
            'id_sekolah'    => $data['id_sekolah'],
            'name'          => $data['name'],
            'alamat'        => $data['alamat'],
            'provinsi'      => $data['provinsi'],
            'kabupaten'     => $data['kabupaten'],
            'jenjang'       => $data['jenjang'],
            'tahun_ajaran'  => $data['tahun_ajaran'],
            // 'logo'          => $data['logo']
        ])->id;
        $adminRole = Role::where('name', 'admin')->first();

        User::create([
            'id_sekolah'    => $sekolahId,
            'role_id'       => $adminRole->id,
            'name'          => $data['name'],
            'username'      => $data['username'],
            'password'      => Hash::make($data['password'])
        ]);

        return back()->with(CRUDResponse::successCreate("sekolah " . $data['name']));
    }

    public function edit($id) {
        $user = User::find($id);

        return response()
            ->json([
                'user'      => User::where('id', $user->id)->get(),
            ]);
    }

    public function update(Request $req) {
        $data = $req->all();
        $id = $data['hidden_id'];
        User::findOrFail($id);

        $rules = [
           'id_sekolah'    => 'max:100',
           'name'          => 'required|max:100',
           'alamat'        => 'required',
           'provinsi'        => 'required',
           'kabupaten'        => 'required',
           'jenjang'       => 'required',
           'tahun_ajaran'  => 'required',
       ];

       $message = [
           'id_sekolah.required' => 'Kolom ini gaboleh kosong',
       ];

       $validator = Validator::make($data, $rules, $message);

       if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all())->withInput();
       }

       User::whereId($id)->update([
           'id_sekolah'    => $data['id_sekolah'],
           'name'          => $data['name'],
           'alamat'        => $data['alamat'],
           'provinsi'        => $data['provinsi'],
           'kabupaten'        => $data['kabupaten'],
           'jenjang'       => $data['jenjang'],
           'tahun_ajaran'  => $data['tahun_ajaran'],
           // 'logo'          => $data['logo']
       ]);

       return back()->with(CRUDResponse::successUpdate("sekolah " . $data['name']));
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
