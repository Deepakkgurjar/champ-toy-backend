<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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

    //for Seller Login


    //for Admin Login
}
