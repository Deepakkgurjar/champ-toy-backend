<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    
    //for Purchaser Login
    public function Login(Request $request){
        
        $rules=[
            'email'=>'required|email|exists:users,email',
            'password'=>'required',
        ];
        $messages=[
            'email.required'=>'Please Enter Your Email-id',
            'password.required'=>'Please Enter Password',
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
            if($validator->fails()){
                $response['return'] = false;
                $response['errors'] = $validator->errors()->toArray();
                $response['errors_key'] = array_keys($validator->errors()->toArray());
                return response()->json($response, 400);
            }else{

                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    $user=User::where('email',$request->email)->first();
                    if ($user->tokens()->count() > 0) {
                        $user->tokens()->delete();
                    }
                    $response['return']=true;
                    $response['message'] = "Sucessfully login welcome";
                    $response['token']=$user->createToken('API TOKEN')->plainTextToken;
                    $response['data'] = $user;
                    return response()->json($response, 200);
                } else {
                    $response['return']=false;
                    $response['message'] = "You entered wrong password, please confirm your password";
                    return response()->json($response, 400);
                }
            }
    }

    //for Purchaser logout
    public function Logout(Request $request){
        
        // dd(Auth::guard()->check());

        if (Auth::guard()->check()) {
            // auth()->guard('web')->logout();
            // $user=Auth::user();
            // $user->currentAccessToken()->delete();
            //Auth::guard("sanctum")->logout();
           //Auth::guard("web")->logout();
            Auth::user()->currentAccessToken()->delete();
            $response['return']=true;
            $response['message'] = "Sucessfully logout";
            $response['data'] = null;
            return response()->json($response, 200);
        } else {
            $response['return']=false;
            $response['message'] = "Something went wrong!";
            return response()->json($response, 400);
        }
        //auth()->user()->tokens()->delete();
    }

    //for Seller Login
    public function LoginSeller(Request $request){

        $rules=[
            'email'=>'required|email|exists:sellers,email',
            'password'=>'required',
        ];
        $messages=[
            'email.required'=>'Please Enter Your Email-id',
            'password.required'=>'Please Enter Password',
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
            if($validator->fails()){
                $response['return'] = false;
                $response['errors'] = $validator->errors()->toArray();
                $response['errors_key'] = array_keys($validator->errors()->toArray());
                return response()->json($response, 400);
            }else{
                // auth()->guard('seller')->attempt(['email' => $request->email, 'password' => $request->password])
                $user=Seller::where('email',$request->email)->first();
                if (!$user || !Hash::check($request['password'], $user->password)) {

                    $response['return']=false;
                    $response['message'] = "You entered wrong password, please confirm your password";
                    return response()->json($response, 400);
                    
                } else {
                    if ($user->tokens()->count() > 0) {
                        $user->tokens()->delete();
                    }
                    $response['return']=true;
                    $response['message'] = "Sucessfully login welcome";
                    $response['token']=$user->createToken('API TOKEN')->plainTextToken;
                    $response['data'] = $user;
                    return response()->json($response, 200);
                }
            }
    }
    
    //for Seller Logout
    public function LogoutSeller(Request $request){
        
        // dd(Auth::guard()->check());
        if (Auth::guard('seller')->check()) {
            Auth::user()->currentAccessToken()->delete();
            $response['return']=true;
            $response['message'] = "Sucessfully logout";
            $response['data'] = null;
            return response()->json($response, 200);
        } else {
            $response['return']=false;
            $response['message'] = "Something went wrong!";
            return response()->json($response, 400);
        }
        //auth()->user()->tokens()->delete();
    }
}
