<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(["success"=>false,'message'=>"Validation fail",'data'=>$validator->errors()], 422);
        }

        if (! $token = auth()->guard('api')->attempt($validator->validated())) {
            return response()->json(["success"=>false,'message' => 'Invalid Email or Password','data'=>[]], 401);
        }

        return $this->createNewToken($token);
    }

    protected function createNewToken($token){
        return response()->json([
            "success"=>true,
            "message"=>"Login",
            "data"=>[
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'user' => auth('api')->user()
            ]
        ]);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if($validator->fails()){
            return response()->json(["success"=>false,'message'=>"Validation fail",'data'=>$validator->errors()], 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        $token = auth()->guard('api')->attempt(['email'=>$request->input('email'),'password'=>$request->input('password')]);
        return $this->createNewToken($token);        
    }

    public function refresh_token() {
        return $this->createNewToken(auth('api')->refresh());
    }

    public function profile() {
        return response()->json([
            "success"=>true,
            "message"=>"Profile",
            "data"=>[
                'user' => auth('api')->user()
            ]
        ],200);
    }

    public function logout() {
        auth('api')->logout();
        return response()->json([
            "success"=>true,
            "message"=>"User successfully signed out",
            "data"=>[]
        ],200);
    }

}
