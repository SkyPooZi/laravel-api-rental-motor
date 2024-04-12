<?php

use Illuminate\Http\Request;
use App\Http\Controllers\DiskonController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('diskon', [DiskonController::class, 'index']);