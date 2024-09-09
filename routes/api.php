<?php

use App\Http\Controllers\ListMotorController;
use Illuminate\Http\Request;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationDanaController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\RiwayatDataController;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/send-otp', [OTPController::class, 'sendOtp'])->name('sendOtp');
Route::post('user/edit/account/{id}', [UserController::class, 'updateAccount']);
Route::get('/user/all', [UserController::class, 'index']);
Route::get('/list-motor/all', [ListMotorController::class, 'index']);
Route::get('/list-motor/detail/{id}', [ListMotorController::class, 'show']);
Route::get('/diskon/all', [DiskonController::class, 'index']);
Route::get('/review/all', [ReviewController::class, 'index']);
Route::group(["prefix" => "/google"], function(){
    Route::get('/all', [GoogleController::class, 'index']);
    Route::get('/detail', [GoogleController::class, 'show']);
});
Route::group(["prefix" => "/facebook"], function(){
    Route::get('/all', [FacebookController::class, 'index']);
    Route::get('/detail', [FacebookController::class, 'show']);
});

Route::post('/send-notification', [NotificationController::class, 'send']);

Route::middleware(['web'])->group(function () {
    Route::get('/login/google', [UserController::class, 'redirectToGoogle']);
    Route::get('/login/google/callback', [UserController::class, 'handleGoogleCallback']);
    Route::get('/login/facebook', [UserController::class, 'redirectToFacebook']);
    Route::get('/login/facebook/callback', [UserController::class, 'handleFacebookCallback']);
});

Route::middleware('auth:sanctum')->group(function() {
    Route::group(["prefix" => "/user"], function(){
        Route::post('/create', [UserController::class, 'store']);
        Route::get('/detail/{id}', [UserController::class, 'show']);
        Route::post('/edit/{id}', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    });
    
    Route::group(["prefix" => "/list-motor"], function(){
        Route::post('/create', [ListMotorController::class, 'store']);
        Route::post('/edit/{id}', [ListMotorController::class, 'update']);
        Route::post('/editDate/{id}', [ListMotorController::class, 'updateDate']);
        Route::delete('/delete/{id}', [ListMotorController::class, 'destroy']);
    });
    
    Route::group(["prefix" => "/history"], function(){
        Route::get('/all', [HistoryController::class, 'index']);
        Route::get('/detail/{id}', [HistoryController::class, 'show']);
        Route::get('/filtered/status', [HistoryController::class, 'getFilteredStatusHistory']);
        Route::get('/filtered', [HistoryController::class, 'getFilteredHistory']);
        Route::post('/create', [HistoryController::class, 'store']);
        Route::post('/edit/{id}', [HistoryController::class, 'update']);
        Route::delete('/delete/{id}', [HistoryController::class, 'destroy']);
    });
    
    Route::group(["prefix" => "/diskon"], function(){
        Route::get('/detail/{id}', [DiskonController::class, 'show']);
        Route::post('/create', [DiskonController::class, 'store']);
        Route::post('/edit/{id}', [DiskonController::class, 'update']);
        Route::delete('/delete/{id}', [DiskonController::class, 'destroy']);
    });
    
    Route::group(["prefix" => "/review"], function(){
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

    Route::group(["prefix" => "/notification-dana"], function(){
        Route::get('/all', [NotificationDanaController::class, 'index']);
        Route::get('/detail/{id}', [NotificationDanaController::class, 'show']);
        Route::post('/create', [NotificationDanaController::class, 'store']);
        Route::post('/edit/{id}', [NotificationDanaController::class, 'update']);
        Route::delete('/delete/{id}', [NotificationDanaController::class, 'destroy']);
    });

    Route::group(["prefix" => "/keuangan"], function(){
        Route::get('/all', [KeuanganController::class, 'index']);
        Route::get('/detail/{id}', [KeuanganController::class, 'show']);
        Route::post('/create', [KeuanganController::class, 'store']);
        Route::post('/edit/{id}', [KeuanganController::class, 'update']);
        Route::delete('/delete/{id}', [KeuanganController::class, 'destroy']);
    });

    Route::group(["prefix" => "/riwayat-data"], function(){
        Route::get('/all', [RiwayatDataController::class, 'index']);
        Route::get('/detail/{id}', [RiwayatDataController::class, 'show']);
        Route::get('/detail-list-motor/{id}', [RiwayatDataController::class, 'showListMotor']);
        Route::get('/detail-history/{id}', [RiwayatDataController::class, 'showHistory']);
        Route::post('/create', [RiwayatDataController::class, 'store']);
        Route::post('/edit/{id}', [RiwayatDataController::class, 'update']);
        Route::delete('/delete/{id}', [RiwayatDataController::class, 'destroy']);
    });

    Route::group(["prefix" => "/invoice"], function(){
        Route::get('/all', [MidtransController::class, 'index']);
        Route::get('/detail/{id}', [MidtransController::class, 'show']);
        Route::post('/create/{id}', [MidtransController::class, 'store']);
    });
    
    Route::get('/payment/{id}', [MidtransController::class, 'showPaymentPage']);
    Route::post('/payment-reschedule/{id}', [MidtransController::class, 'showPaymentReschedulePage']);
    Route::post('/update-invoice/{order_id}', [MidtransController::class, 'updateInvoiceMidtrans']);
});
