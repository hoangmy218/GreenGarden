<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailsOrder;
use Validator;


class DetailsOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detailsOrder_list = DetailsOrder::get();
        return response()->json(DetailsOrder::get(), 200);
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
            'qty' => 'required',
            'price' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $detailsOrder = DetailsOrder::create($request->all());
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
        $detailsOrder = DetailsOrder::find($id);
        if (is_null($detailsOrder))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        return response()->json($detailsOrder, 200);
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
            'qty' => 'required',
            'price' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }
        $detailsOrder = DetailsOrder::find($id);
        if (is_null($detailsOrder))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }

        $detailsOrder->update($request->all());
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
        $detailsOrder = DetailsOrder::find($id);
        if (is_null($detailsOrder))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        $detailsOrder->delete();
        return response()->json('Deleted Successfully', 200);
    }
}
