<?php

use App\Http\Controllers\ListMotorController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["prefix" => "/user"], function(){
    Route::get('/all', [UserController::class, 'index']);
    Route::get('/detail/{id}', [UserController::class, 'show']);
    Route::post('/create', [UserController::class, 'store']);
    Route::get('/edit/{id}', [UserController::class, 'update']);
    Route::get('/delete/{id}', [UserController::class, 'destroy']);
});

Route::group(["prefix" => "/diskon"], function(){
    Route::get('/all', [DiskonController::class, 'index']);
    Route::get('/detail/{id}', [DiskonController::class, 'show']);
    Route::post('/create', [DiskonController::class, 'store']);
    Route::get('/edit/{id}', [DiskonController::class, 'update']);
    Route::get('/delete/{id}', [DiskonController::class, 'destroy']);
});

Route::group(["prefix" => "/review"], function(){
    Route::get('/all', [ReviewController::class, 'index']);
    Route::get('/detail/{id}', [ReviewController::class, 'show']);
    Route::post('/create', [ReviewController::class, 'store']);
    Route::get('/edit/{id}', [ReviewController::class, 'update']);
    Route::get('/delete/{id}', [ReviewController::class, 'destroy']);
});

Route::group(["prefix" => "/list-motor"], function(){
    Route::get('/all', [ListMotorController::class, 'index']);
    Route::get('/detail/{id}', [ListMotorController::class, 'show']);
    Route::post('/create', [ListMotorController::class, 'store']);
    Route::get('/edit/{id}', [ListMotorController::class, 'update']);
    Route::get('/delete/{id}', [ListMotorController::class, 'destroy']);
});
