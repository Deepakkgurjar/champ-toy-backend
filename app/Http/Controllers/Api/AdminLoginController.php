<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AdminLoginController extends Controller
{
    
    protected string $guard = 'admin';
    
    public function LoginAdmin(Request $request){

        //dd(Auth::guard($this->guard));
    
        $rules=[
            'email'=>'required|email|exists:admins,email',
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
                
                $user=Admin::where('email',$request->email)->first();
                
                //if (Auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
                if (!$user || !Hash::check($request['password'], $user->password)){
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
    public function Logout(){
        
        if (Auth::guard('admin')->check()) {
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

