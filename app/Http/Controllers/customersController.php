<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\customers;
use Illuminate\Support\Facades\Validator;

class customersController extends Controller
{
    public function show ()
    {
        return customers::all();
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'nama_customer' => 'required',
                'alamat' => 'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = customers::create([
            'nama_customer' => $request->nama_customer,
            'alamat' => $request->alamat
        ]);

        if($simpan) {
            return Response()->json(['status'=>1]);
        }
        else {
            return Response()->json(['status'=>0]);
        }
    }

    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'nama_customer' => 'required',
                'alamat' => 'required'
            ]
        );
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $ubah = customers::where('id_customers', $id)->update([
            'nama_customer' => $request->nama_customer,
            'alamat' => $request->alamat
        ]);

        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}