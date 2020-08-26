<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class FileController extends Controller
{
    public function productList($fileName){
        return response()->download(public_path("/images/"+$fileName),'User Image');
    }

    public function productSave(Request $request)
    {
        //dd($request->all());
        if ($request->hasFile('photo'))
        {
            
            $newdate = Carbon::now()->format('Y_m_d_H_i_s');
            $fileName = "product_" . $newdate . ".png";
            $path = $request->file('photo')->move(public_path("/images"), $fileName);
            $photoURL = url("/images/".$fileName);
            return response()->json(['url' => $photoURL],200);
            
        }
        else
        {
            return response()->json(["message" => "Select image first."]);
        }

    }
}
