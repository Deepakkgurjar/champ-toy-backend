<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class RegisterController extends Controller
{
    //for Purchaser Register
    public function Register(Request $request){
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required',
            

        ];
        $messages=[
            'name.required'=>'Please Enter Your Name',
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
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password=Hash::make($request->password);
                $user->save();
                if (!empty($user)) {
                    $response['return']=true;
                    $response['message'] = "Account created.";
                    $response['token']=$user->createToken('API TOKEN')->plainTextToken;
                    $response['data'] = null;
                    return response()->json($response,200);
                }
                    $response['true'] = false;
                    $response['message']="OOPS! Something went Wrong!!";
                    return response()->json($response, 400);
            }
    }

    //for Admin Register
    public function RegisterAdmin(Request $request){
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:admins,email',
            'password'=>'required',
            

        ];
        $messages=[
            'name.required'=>'Please Enter Your Name',
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
                $user = new Admin();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password=Hash::make($request->password);
                $user->save();
                if (!empty($user)) {
                    $response['return']=true;
                    $response['message'] = "Account created.";
                    $response['token']=$user->createToken('API TOKEN')->plainTextToken;
                    $response['data'] = null;
                    return response()->json($response,200);
                }
                    $response['true'] = false;
                    $response['message']="OOPS! Something went Wrong!!";
                    return response()->json($response, 400);
            }
    }

    //for Seller Register
    
    
    public function RegisterSeller(Request $request){
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:sellers,email',
            'password'=>'required',
            

        ];
        $messages=[
            'name.required'=>'Please Enter Your Name',
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
                $user = new Seller();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password=Hash::make($request->password);
                $user->save();
                if (!empty($user)) {
                    $response['return']=true;
                    $response['message'] = "Account created.";
                    $response['token']=$user->createToken('API TOKEN')->plainTextToken;
                    $response['data'] = null;
                    return response()->json($response,200);
                }
                    $response['true'] = false;
                    $response['message']="OOPS! Something went Wrong!!";
                    return response()->json($response, 400);
            }
    }
}
