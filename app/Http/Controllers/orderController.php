<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\order;
use Illuminate\Support\Facades\Validator;

class orderController extends Controller
{
    public function show()
    {
        $data_order = order::join('customers', 'order.id_customers', 'customers.id_customers')->leftjoin('product', 'order.id_product', 'product.id_product')->get();
        return Response()->json($data_order);
    }

    public function detail($id)
    {
        if(order::where('id_order', $id)->exists()){
            $data_order = order::join('customers', 'order.id_customers', 'customers.id_customers')->leftjoin('product', 'order.id_product', 'product.id_product')
                                        ->where('order.id_order', '=', $id)
                                        ->get();

            return Response()->json($data_order);
        }
        else{
            return Response()->json(['message' => 'Tidak ditemukan']);
        }
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'id_customers' => 'required',
                'id_product' => 'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = order::create([
            'id_customers' => $request->id_customers,
            'id_product' => $request->id_product
        ]);

        if($simpan)
        {
            return Response()->json(['status' => 1]);
        }
        else
        {
            return Response()->json(['status' => 0]);
        }
    }

    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
            [                
                'id_customers' => 'required',
                'id_product' => 'required',
            ]
        );

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = order::where('id_order', $id)->update([            
            'id_customers' => $request->id_customers,
            'id_product' => $request->id_product,
        ]);

        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }

    public function destroy($id)
    {
        $hapus = order::where('id_order', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->sjon(['status' => 0]);
        }
    }
}
