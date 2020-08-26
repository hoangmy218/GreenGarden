<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User; 
use Validator;
use DB;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email', 
            'password' => 'required', 
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $credentials = $request->all();
        $user = User::where('email',$request['email'])->first();
        if ($user == null){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $role = $user->role_id;
        $user_id = $user->id;
        $user_name = $user->name;
        if (! $token = auth()->claims(['role'=>$role,'user_id'=>$user_id, 'user_name'=>$user_name])->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function signup(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($request['password']!= $request['c_password']){
            return response()->json(['error'=>'Password are not matching'], 401);            
        }
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $input['role_id'] = '2'; //Customer
        $input['active'] = '0'; //have not verify email yet
        // $user = User::create($input); 
        // $user = User::create($input)->sendEmailVerificationNotification();
        $user = User::create($input);
        // $user->sendEmailVerificationNotification();
        $role = $user['role_id'];
        $user_id = $user['id'];
        $user_name = $user['name'];


        //Send Email with CODE
        $email = $input['email'];
        $code = rand(1000,999999);
        $user_act['user_id'] = $user['id'];
        $user_act['activation_code']= $code; 
        Db::table('user_activations')->insert($user_act);
        $meessageData = ['email'=>$input['email'], 'name'=>$input['name'], 'code'=>$code];
        Mail::send('email.register', $meessageData, function($message) use($email){
            $message->to($email)->subject('Registration with Green Garden Shop');
        });

        $credentials = $request->all();
        if (! $token = auth()->claims(['role'=>$role, 'user_id'=> $user_id, 'user_name'=>$user_name, 'user'=>$user])->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        
        // event(new Registered($user));
        // //$this->guard()->login($user);

        // $this->activationService->sendActivationMail($user);
        return $this->respondWithToken($token);
    }

    // public function activateUser($token)
    // {
    //     if ($user = $this->activationService->activateUser($token)) {
    //         auth()->login($user);
    //         return response()->json(['message' => 'Active Successfully'], 200);
    //     }
    //     // abort(404);
    // }

   

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    // public function register(RegisterFormRequest $request)
    // {
    //     $params = $request->only('email', 'name', 'password');
    //     $user = new User();
    //     $user->email = $params['email'];
    //     $user->name = $params['name'];
    //     $user->password = bcrypt($params['password']);
    //     $user->role_id = '2';
    //     $user->save();

    //     return response()->json($user, Response::HTTP_OK);
    // }

    
    public function payload()
    {
        return auth()->payload();
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email',      
        ]);       
        if ($validator->fails()) { 
            return response()->json(['message'=>$validator->errors()], 401);            
        }
        
        $current_user = auth()->user();
        $user = User::where('email',$request['email'])->first();
        if (!is_null($user)){
            if ($current_user['id'] != $user['id']){
                return response()->json(['message'=>'Email is exist'], 401); 
            }
        }

        $current_user->update($request->all());
        return response()->json(['message' => 'Updated successfully'], 200);
    }

    public function getVerifyCode(){
        $user = auth()->user();
        $user_code =  Db::table('user_activations')->where('user_id',$user['id'])->get();
        return response()->json(['verification_code'=>$user_code['activation_code']], 200);
    }

    public function activateUser(Request $request)
    {
        $user = auth()->user();
        $user_code = Db::table('user_activations')->where('user_id',$user['id'])->first();
        $input = $request->all();
        $in_code = json_decode($input['code'], true);
        $code = $in_code;
        if ($user_code->activation_code==$code)
        {
            $user->update(['active'=>true]);
            return response()->json(['message' => 'Verify successfully', 'user'=>$user], 200);
        }
        return response()->json(['message' => $user_code['activation_code'], 'input'=>$input], 401);
    }

    public function resendEmail(Request $request)
    {
        $user = auth()->user();
        $code = rand(1000,999999);
        $email = $user['email'];
        Db::table('user_activations')->where('user_id',$user['id'])->update(['activation_code'=>$code]);
        $meessageData = ['email'=>$user['email'], 'name'=>$user['name'], 'code'=>$code];
        Mail::send('email.register', $meessageData, function($message) use($email){
            $message->to($email)->subject('Registration with Green Garden Shop');
        });
        return response()->json(['message' => 'Resend email successfully'], 200);
    }
    

}