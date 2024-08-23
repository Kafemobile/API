<?php

use App\Http\Controllers\test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register',[test::class,'register']);
Route::post('/login',[test::class,'login']);

Route::middleware('auth:api')->group(function(){
    Route::get('/test',function(){
        return response()->json([
            'msg'=>'hellow u can access this route :D'
        ]); 
    });
});