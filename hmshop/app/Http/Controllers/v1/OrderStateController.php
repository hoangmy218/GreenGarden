<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Models\OrderState;
use Validator;


class OrderStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderState_list = OrderState::get();
        return response()->json(OrderState::get(), 200);
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
        // $rules = [
        //     'st_name' => 'required|min:1|max:255', 
        // ];
        // $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails())
        // {
        //     return response()->json($validator->errors(), 400);
        // }

        // $orderState = OrderState::create($request->all());
        // // return response()->json($department, 201);
        // return response()->json('Added successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderState = OrderState::find($id);
        if (is_null($orderState))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        return response()->json($orderState, 200);
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
        // $rules = [
        //     'st_name' => 'required|min:1|max:255', 
        // ];
        // $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails())
        // {
        //     return response()->json($validator->errors(), 400);
        // }
        // $orderState = OrderState::find($id);
        // if (is_null($orderState))
        // {
        //     return response()->json(['message'=> 'Record not found'],404);
        // }

        // $orderState->update($request->all());
        // // return response()->json($department, 201);
        // return response()->json('Updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $orderState = OrderState::find($id);
        // if (is_null($orderState))
        // {
        //     return response()->json(['message'=> 'Record not found'],404);
        // }
        // $orderState->delete();
        // return response()->json('Deleted Successfully', 200);
    }
}
