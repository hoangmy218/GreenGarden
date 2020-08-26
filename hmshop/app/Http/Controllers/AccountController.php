<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Account;
use Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account_list = Account::get();
        return response()->json(Account::get(), 200);
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
            'acc_name' => 'required|min:1|max:255',
            'acc_mail' => 'required|email|max:50',
            'acc_password' => 'required',
            'acc_phone' => 'required|min:10',
            'acc_dob' => 'required',
            'acc_address' => 'required',
            'role_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $account = Account::create($request->all());
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
        $account = Account::find($id);
        if (is_null($account))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        return response()->json($account, 200);
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
            
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }
        $account = Account::find($id);
        if (is_null($account))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }

        $account->update($request->all());
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
        $account = Account::find($id);
        if (is_null($account))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        $account->delete();
        return response()->json('Deleted Successfully', 200);
    }
}
