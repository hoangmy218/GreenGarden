<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category_list = Category::orderBy('cate_id', 'DESC')->get();
        return response()->json($category_list, 200);
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
            'cate_name' => 'required|min:1|max:60',
            'cate_des' => 'required|min:10',
            
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json(['message'=>$validator->errors()], 400);
        }

        $category = Category::create($request->all());
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
        $category = Category::find($id);
        if (is_null($category))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        return response()->json($category, 200);
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
            'cate_name' => 'required|min:1|max:60',
            'cate_des' => 'required|min:10',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }
        $category = Category::find($id);
        if (is_null($category))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }

        $category->update($request->all());
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
        $category = Category::find($id);
        if (is_null($category))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        $category->delete();
        return response()->json(['message'=>'Deleted Successfully'], 200);
    }
}
