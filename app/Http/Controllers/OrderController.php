<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //
    function setOrder(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'full_name' => 'required|string',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'total_price' => 'required|string',
            'payment_method' => 'required|string',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'province_state' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        Order::create([
            'user_id' => $request->id,
            'full_name' => $request->full_name,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'payment_method' => $request->payment_method,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'City' => $request->city,
            'province/state' => $request->province_state,
            'notes' => $request->notes,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
        ], 201);
    }

    function getOrder($id){
        $orders = Order::where('user_id', $id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $orders,
        ], 200);
    }
}
