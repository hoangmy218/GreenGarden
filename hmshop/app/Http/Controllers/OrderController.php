<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Validator;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_list = Order::get();
        return response()->json(Order::get(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'order_date' => 'required',
            'order_total' => 'required',    
            'order_address' => 'required|max:100',
            'acc_id' => 'required',
            'st_id' => 'required',
            'pm_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $order = Order::create($request->all());
        // return response()->json($department, 201);
        return response()->json('Added successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        if (is_null($order))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        return response()->json($order, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'order_date' => 'required',
            'order_total' => 'required',
            'order_address' => 'required|max:100',
            'acc_id' => 'required',
            'st_id' => 'required',
            'pm_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }
        $order = Order::find($id);
        if (is_null($order))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }

        $order->update($request->all());
        // return response()->json($department, 201);
        return response()->json('Updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if (is_null($order))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        $order->delete();
        return response()->json('Deleted Successfully', 200);
    }

    public function updateStateOrder(Request $request, $id)
    {
        // $rules = [
        //     'st_id' => 'required',
        // ];
        // $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails())
        // {
        //     return response()->json($validator->errors(), 400);
        // }
        $order = Order::find($id);
        if (is_null($order))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }

        $order->update($request->all());
        // return response()->json($department, 201);
        return response()->json(['message'=>'Updated successfully'], 200);
    }
}
