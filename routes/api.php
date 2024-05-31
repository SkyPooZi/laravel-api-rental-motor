<?php

use App\Http\Controllers\ListMotorController;
use Illuminate\Http\Request;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OtpController;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [UserController::class, 'login']);
Route::post('/user/create', [UserController::class, 'store']);

Route::middleware(['web'])->group(function () {
    Route::get('/login/google', [UserController::class, 'redirectToGoogle']);
    Route::get('/login/google/callback', [UserController::class, 'handleGoogleCallback']);
    Route::get('/login/facebook', [UserController::class, 'redirectToFacebook']);
    Route::get('/login/facebook/callback', [UserController::class, 'handleFacebookCallback']);
});

Route::middleware('auth:sanctum')->group(function() {
    Route::group(["prefix" => "/user"], function(){
        Route::get('/all', [UserController::class, 'index']);
        Route::get('/detail/{id}', [UserController::class, 'show']);
        Route::post('/edit/{id}', [UserController::class, 'update']);
        Route::post('/edit/account/{id}', [UserController::class, 'updateAccount']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    });
    
    Route::group(["prefix" => "/list-motor"], function(){
        Route::get('/all', [ListMotorController::class, 'index']);
        Route::get('/detail/{id}', [ListMotorController::class, 'show']);
        Route::post('/create', [ListMotorController::class, 'store']);
        Route::post('/edit/{id}', [ListMotorController::class, 'update']);
        Route::delete('/delete/{id}', [ListMotorController::class, 'destroy']);
    });
    
    Route::group(["prefix" => "/history"], function(){
        Route::get('/all', [HistoryController::class, 'index']);
        Route::get('/detail/{id}', [HistoryController::class, 'show']);
        Route::post('/create', [HistoryController::class, 'store']);
        Route::post('/edit/{id}', [HistoryController::class, 'update']);
        Route::delete('/delete/{id}', [HistoryController::class, 'destroy']);
    });
    
    Route::group(["prefix" => "/diskon"], function(){
        Route::get('/all', [DiskonController::class, 'index']);
        Route::get('/detail/{id}', [DiskonController::class, 'show']);
        Route::post('/create', [DiskonController::class, 'store']);
        Route::post('/edit/{id}', [DiskonController::class, 'update']);
        Route::delete('/delete/{id}', [DiskonController::class, 'destroy']);
    });
    
    Route::group(["prefix" => "/review"], function(){
        Route::get('/all', [ReviewController::class, 'index']);
        Route::get('/detail/{id}', [ReviewController::class, 'show']);
        Route::post('/create', [ReviewController::class, 'store']);
        Route::post('/edit/{id}', [ReviewController::class, 'update']);
        Route::delete('/delete/{id}', [ReviewController::class, 'destroy']);
    });

    Route::group(["prefix" => "/notification"], function(){
        Route::get('/all', [NotificationController::class, 'index']);
        Route::get('/detail/{id}', [NotificationController::class, 'show']);
        Route::post('/create', [NotificationController::class, 'store']);
        Route::post('/edit/{id}', [NotificationController::class, 'update']);
        Route::delete('/delete/{id}', [NotificationController::class, 'destroy']);
    });
    
    Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('sendOtp');
    Route::get('/payment/{id}', [MidtransController::class, 'showPaymentPage']);
    Route::get('/update-invoice/{order_id}', [MidtransController::class, 'updateInvoiceMidtrans']);
    Route::get('/invoice', [MidtransController::class, 'index']);
});
