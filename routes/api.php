<?php

use App\Http\Controllers\ListMotorController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use App\Http\Controllers\DiskonController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('diskon', [DiskonController::class, 'index']);
Route::post('diskon', [DiskonController::class, 'store']);
Route::get('diskon/{id}', [DiskonController::class, 'show']);
Route::get('diskon/{id}/edit', [DiskonController::class, 'edit']);
Route::put('diskon/{id}/edit', [DiskonController::class, 'update']);

Route::get('review', [ReviewController::class, 'index']);
Route::get('review', [ReviewController::class, 'store']);
Route::get('review/{id}', [ReviewController::class, 'show']);
Route::get('review/{id}/edit', [ReviewController::class, 'edit']);
Route::put('review/{id}/edit', [ReviewController::class, 'update']);

Route::get('list-motor', [ListMotorController::class, 'index']);
Route::get('list-motor', [ListMotorController::class, 'store']);
Route::get('list-motor/{id}', [ListMotorController::class, 'show']);
Route::get('list-motor/{id}/edit', [ListMotorController::class, 'edit']);
Route::put('list-motor/{id}/edit', [ListMotorController::class, 'update']);