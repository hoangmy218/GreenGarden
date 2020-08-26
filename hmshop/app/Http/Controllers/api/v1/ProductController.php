<?php

namespace App\Http\Controllers\api\v1;

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
        $product_list = Product::paginate(6);
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
        // $rules = [
        //     'pro_name' => 'required|min:1|max:255',
        //     'pro_des' => 'required|max:50',
        //     'pro_price' => 'required',
        //     'pro_stock' => 'required',
        //     'cate_id' => 'required',
        // ];
        // $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails())
        // {
        //     return response()->json($validator->errors(), 400);
        // }

        // $product = Product::create($request->all());
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
        // $rules = [
        //     'pro_name' => 'required|min:1|max:255',
        //     'pro_des' => 'required|max:50',
        //     'pro_price' => 'required',
        //     'pro_stock' => 'required',
        //     'cate_id' => 'required',
        // ];
        // $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails())
        // {
        //     return response()->json($validator->errors(), 400);
        // }
        // $product = Product::find($id);
        // if (is_null($product))
        // {
        //     return response()->json(['message'=> 'Record not found'],404);
        // }

        // $product->update($request->all());
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
        // $product = Product::find($id);
        // if (is_null($product))
        // {
        //     return response()->json(['message'=> 'Record not found'],404);
        // }
        // $product->delete();
        // return response()->json('Deleted Successfully', 200);
    }
}
