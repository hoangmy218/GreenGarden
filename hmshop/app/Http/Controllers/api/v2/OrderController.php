<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\DetailsOrder;
use Validator;
use DB;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_list = Order::orderBy('order_id', 'DESC')->get();
        return response()->json($order_list, 200);
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
            'order_name' => 'required',
            'order_phone' => 'required',
            'order_date' => 'required',
            'order_total' => 'required',    
            'order_address' => 'required|max:255',
            'user_id' => 'required',
            'st_id' => 'required',
            'pm_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $order = Order::create($request->all());
        $order_id = $order->order_id;
        $orderItems = array();
        $orderItems  = $request->OrderItems;
        $item;
        $dorder = array();
        $i=0;
        $error ='';
        $outOfStock = array();
        foreach($orderItems as $value){
            $item = $value;
            $item['order_id']= $order_id;
            try{
                $pro = Product::find($item['pro_id']);
                if (is_null($pro)){
                    $error = $error.'Cannot not found product with ID '.$item['pro_id'].'. ';
                }
                else{
                    if ($pro->pro_stock >= $item['qty']){
                        DB::table('details_orders')->insert($item);
                        $new_stock = $pro->pro_stock - $item['qty'];
                        $pro->update(['pro_stock'=> $new_stock]);
                    }else{
                        $outOfStock[$i] = $item;
                        $i++;
                    }
                }
            }catch (\Illuminate\Database\QueryException $e) {
                $error = $error.'Added order item failed. ';
            }
            
        }
        if ($outOfStock != null){
            $error = $error."Do not have enough product in stock. ";
           
        }
        if ($error != ''){
            return response()->json(['message'=>$error, 'data'=>$outOfStock],400);
        }

        return response()->json(['message'=>'Placed order successfully'], 201);
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
            'order_name' => 'required',
            'order_phone' => 'required',
            'order_date' => 'required',
            'order_total' => 'required',    
            'order_address' => 'required|max:255',
            'user_id' => 'required',
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


    public function updateStateOrder(Request $request, $order_id, $state_id)
    {
        $order = Order::find($order_id);
        if (is_null($order))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }

        $order->update(['st_id'=>$state_id]);
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
        $order = Order::find($id);
        if (is_null($order))
        {
            return response()->json(['message'=> 'Record not found'],404);
        }
        $order->delete();
        return response()->json('Deleted Successfully', 200);
    }


    public function getTotalNewOrder()
    {
        $order_list = Order::where('st_id',1)->get();
        return response()->json($order_list->count(), 200);
    }

    public function getTotalRevenue()
    {
        $totalRevenue = 0;
        $order_list = Order::get();
        foreach($order_list as $order)
        {
            $totalRevenue += $order['order_total'];
        }
        return response()->json(['totalRevenue'=>$totalRevenue], 200);
    }


}
