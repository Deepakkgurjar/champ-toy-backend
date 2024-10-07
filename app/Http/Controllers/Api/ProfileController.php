<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{

    public function index(){
        //dd(Auth::guard('web')->check());
        if (Auth::guard('sanctum')->check()) {
            $userData=Auth::user();
            $response['return']=true;
            $response['message'] = "Welcome ".$userData->name;
            $response['data'] = $userData;
            return response()->json($response, 200);
        } else {
            $response['return']=false;
            $response['message'] = "Something went wrong!";
            return response()->json($response, 400);

        }
        
    }
}
