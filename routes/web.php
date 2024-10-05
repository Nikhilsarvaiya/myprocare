<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScrapingController;
use Illuminate\Support\Facades\Route;

Route::get('/api-login', [ScrapingController::class, 'getLoginApiData']);
Route::get('/api-report', [ScrapingController::class, 'apiReport']);
Route::get('/api-hold-report', [ScrapingController::class, 'apiHoldReport']);
Route::get('/api-call-report', [ScrapingController::class, 'callReports']);


Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

require __DIR__.'/user/web.php';

require __DIR__.'/admin/web.php';
