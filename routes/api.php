<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('business-types',[\App\Http\Controllers\Api\User\BusinessTypeController::class,'index']);


Route::middleware('guest')->group(function (){

    Route::post('login',[\App\Http\Controllers\Api\Auth\AuthenticatedController::class,'store']);
});


Route::middleware('auth:sanctum')->group(function (){

    Route::post('logout',[\App\Http\Controllers\Api\Auth\AuthenticatedController::class,'destroy']);

    Route::get('profile', [\App\Http\Controllers\Api\User\ProfileController::class,'index']);

    Route::apiResource('events', \App\Http\Controllers\Api\User\EventController::class)->except(['show']);

});


