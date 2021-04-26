<?php

namespace App\Http\Controllers\Superadmin\Pengumuman;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Validator;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     $data = Message::latest()->get();
        //     return DataTables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn('action', function ($data) {
        //             $button = '<button type="button" id="' . $data->id . '" class="edit btn btn-mini btn-info shadow-sm">Edit</button>';
        //             $button .= '&nbsp;&nbsp;&nbsp;<button type="button" id="' . $data->id . '" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>';
        //             return $button;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        $data = Message::latest()->get();
        return view('superadmin.pengumuman.pengumuman', compact('data'));
        // return $data;
    }

    public function store(Request $request)
    {
        // validasi
        $rules = [
            'title'  => 'required|max:100',
            'message' => 'required',
        ];

        $message = [
            'title.required' => 'Kolom ini tidak boleh kosong',
            'message.required' => 'Kolom ini tidak boleh kosong',
        ];

        $notifikasi = "";
        if ($request->input('notifikasi') == 'Yes') {
            $notifikasi = 'Yes';
        } else {
            $notifikasi = 'No';
        }

        $dashboard = "";
        if ($request->input('dashboard') == 'Yes') {
            $dashboard = 'Yes';
        } else {
            $dashboard = 'No';
        }

        $start = "";
        if ($request->input('message_time') == 'Permanen') {
            $start = date("Y-m-d");
        } else {
            $start = $request->input('start_date');
        }

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()->all()
                ]);
        }

        Message::create([
            'title' => $request->input('title'),
            'notification' => $notifikasi,
            'dashboard' => $dashboard,
            'message_time' => $request->input('message_time'),
            'start_date' => $start,
            'end_date'=> $request->input('end_date'),
            'message'=>$request->input('message'),
            'status' => 'aktif',
        ]);
       

        return response()
            ->json([
                'success' => 'Data Added.',
            ]);
    }

    public function edit($id)
    {
        $messages = Message::find($id);

        return response()
            ->json([
                'messages' => $messages,
            ]);
    }

    public function update(Request $req)
    {
        // validasi
        $rules = [
            'title'  => 'required|max:100',
            'message' => 'required',
        ];

        $message = [
            'title.required' => 'Kolom ini tidak boleh kosong',
            'message.required' => 'Kolom ini tidak boleh kosong',
        ];

        $notifikasi = "";
        if ($req->input('notifikasi') == 'Yes') {
            $notifikasi = 'Yes';
        } else {
            $notifikasi = 'No';
        }

        $dashboard = "";
        if ($req->input('dashboard') == 'Yes') {
            $dashboard = 'Yes';
        } else {
            $dashboard = 'No';
        }

        $start = "";
        if ($req->input('message_time') == 'Permanen') {
            $start = date("Y-m-d");
        } else {
            $start = $req->input('start_date');
        }

        $validator = Validator::make($req->all(), $rules, $message);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()->all()
                ]);
        }
        $update = Message::where('id', $req->hidden_id)->update([
            'title' => $req->title,
            'notification' => $notifikasi,
            'dashboard' => $dashboard,
            'message_time' => $req->input('message_time'),
            'start_date' => $start,
            'end_date' => $req->input('end_date'),
            'message' => $req->input('message'),
            'status' => 'Aktif',
        ]);

        return response()
            ->json([
                'success' => 'Data Updated.',
            ]);
    }

    public function destroy($id)
    {
        $pesan = Message::find($id);
        $pesan->delete();
    }
}
