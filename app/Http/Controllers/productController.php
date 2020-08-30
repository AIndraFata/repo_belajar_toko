<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{
    public function show () 
    {
        return product::all();
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'nama_produk' => 'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = product::create([
            'nama_produk' => $request->nama_produk
        ]);

        if($simpan) {
            return Response()->json(['status'=>1]);
        }
        else {
            return Response()->json(['status'=>0]);
        }
    }
}
