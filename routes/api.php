<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::post('/register',[RegisterController::class,'Register']); //for Purchaser Register
Route::post('/login',[LoginController::class,'Login']); //for Purchaser Login