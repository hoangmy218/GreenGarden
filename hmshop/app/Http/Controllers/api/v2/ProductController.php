<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_list = Product::orderBy('pro_id', 'DESC')->get();
        return response()->json($product_list, 200);
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
            'pro_name' => 'required|min:5|max:100',
            'pro_des' => 'required|min:10',
            'pro_price' => 'required',
            'pro_stock' => 'required',
            'cate_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json(['message'=>$validator->errors()], 400);
        }

        $product = Product::create($request->all());
        // return response()->json($department, 201);
        return response()->json(['message'=>'Added successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        return response()->json($product, 200);
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
            'pro_name' => 'required|min:5|max:100',
            'pro_des' => 'required|min:10',
            'pro_price' => 'required',
            'pro_stock' => 'required',
            'cate_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }
        $product = Product::find($id);
        if (is_null($product))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }

        $product->update($request->all());
        // return response()->json($department, 201);
        return response()->json(['message'=>'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (is_null($product))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        $product->delete();
        return response()->json(['message'=>'Deleted Successfully'], 200);
    }

    public function getTotalProduct()
    {
        $product_list = Product::get();
        return response()->json(['totalProduct'=>$product_list->count()], 200);
    }

    public function getOutOfStock()
    {
        $product_list = Product::where('pro_stock',0)->get();
        return response()->json(['outOfStock'=>$product_list->count()], 200);
    }
}
