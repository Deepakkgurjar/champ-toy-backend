<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\AdminLoginController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Middleware\AdminMiddleware;
/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/


//for Purchaser=============================================================
Route::post('/register',[RegisterController::class,'Register']); //for Purchaser Register
Route::post('/login',[LoginController::class,'Login']); //for Purchaser Login
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/logout',[LoginController::class,'Logout']);
    Route::get('/profile',[ProfileController::class,'index']);
});

//for Seller================================================================
Route::group(['prefix' => 'seller'], function() {
    Route::post('/register',[RegisterController::class,'RegisterSeller']);
    Route::post('/login',[LoginController::class,'LoginSeller']);
    Route::get('/logout',[LoginController::class,'LogoutSeller'])->middleware('auth:seller');
});

//for Admin=================================================================
Route::group(['prefix' => 'admin'], function() {
    Route::post('/register',[RegisterController::class,'RegisterAdmin']);//for Admin Register
    Route::post('/login',[AdminLoginController::class,'LoginAdmin']); //for Admin Login
    Route::get('/logout',[AdminLoginController::class,'Logout'])->middleware('auth:admin');
});
