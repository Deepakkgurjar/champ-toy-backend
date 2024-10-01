<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Home(){

        $response['return']=true;
        $response['message'] = "Sucess";
        $response['data'] = 'dd';
        return response()->json($response, 200);
    }
}
