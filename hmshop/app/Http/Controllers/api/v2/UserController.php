<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request){ 
        // if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
        //     $user = Auth::user(); 
        //     $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        //     return response()->json(['success' => $success], $this-> successStatus); 
        // } 
        // else{ 
        //     return response()->json(['error'=>'Unauthorised'], 401); 
        // } 
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email', 
            'password' => 'required', 
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            // $res = User::where('email',$request['email'])->get();
            // $success['role'] = $res->role_id;
            return response()->json(['success' => $success,'user'=>$user], $this-> successStatus);  
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($request['password']!= $request['c_password']){
            return response()->json(['error'=>"Password are not matching"], 401);            
        }
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $input['role_id'] = '2';
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        $success['role'] = $user->role_id;

        //send Email
        $email = $input['email'];
        $meessageData = ['email'=>$input['email'], 'name'=>$input['name']];
        Mail::send('email.register', $meessageData, function($message) use($email){
            $message->to($email)->subject('Registration with Green Garden Shop');
        });
                
        return response()->json(['success'=>$success, 'user'=>$user], $this-> successStatus); 
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 

    public function getAllUser()
    {
        $user_list = User::get();
        return response()->json($user_list, 200);
    }
}
