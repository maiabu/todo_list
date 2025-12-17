<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Task_atController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/tasks',[Task_atController::class,'index']);
Route::get('/tasks/{task}',[Task_atController::class,'show']);

Route::post('/regiser',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);