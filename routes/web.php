<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [\App\Http\Controllers\Front\PageController::class, 'welcome'])->name('welcome');
Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

require __DIR__.'/user/web.php';

require __DIR__.'/admin/web.php';
