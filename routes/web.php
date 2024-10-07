<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScrapingController;
use Illuminate\Support\Facades\Route;

Route::get('/api-login', [ScrapingController::class, 'getLoginApiData']);
Route::get('/api-report', [ScrapingController::class, 'apiReport']);
Route::get('/api-hold-report', [ScrapingController::class, 'apiHoldReport']);
Route::get('/api-call-report', [ScrapingController::class, 'callReports']);


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [\App\Http\Controllers\Front\PageController::class, 'welcome'])->name('welcome');

Route::get('privacy-policy', [\App\Http\Controllers\Front\PageController::class, 'privacyPolicy'])->name('privacy_policy');
Route::get('terms-and-conditions', [\App\Http\Controllers\Front\PageController::class, 'termsAndConditions'])->name('terms_and_conditions');
Route::get('account-delete-request', [\App\Http\Controllers\Front\AccountDeleteController::class, 'index'])->name('account_delete.index');
Route::post('account-delete-request', [\App\Http\Controllers\Front\AccountDeleteController::class, 'store'])->name('account_delete.store');

Route::middleware('guest')->group(function () {
    Route::get('business-register', [\App\Http\Controllers\BusinessRegister\RegisterController::class, 'create'])
        ->name('business_register.create');

    Route::post('business-register', [\App\Http\Controllers\BusinessRegister\RegisterController::class, 'store'])
        ->name('business_register.store');
});

Route::prefix('business-register')->name('business_register.')->middleware(['auth'])->group(function (){
    Route::get('basic-details/create',[\App\Http\Controllers\BusinessRegister\BasicDetailController::class,'create'])->name('basic_details.create');
    Route::post('basic-details',[\App\Http\Controllers\BusinessRegister\BasicDetailController::class,'store'])->name('basic_details.store');

    Route::get('opening-hours/create',[\App\Http\Controllers\BusinessRegister\OpeningHourController::class,'create'])->name('opening_hours.create');
    Route::post('opening-hours',[\App\Http\Controllers\BusinessRegister\OpeningHourController::class,'store'])->name('opening_hours.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('my-qr', [ProfileController::class, 'myQr'])->name('profile.my-qr');
});

require __DIR__.'/auth.php';

require __DIR__.'/user/web.php';

require __DIR__.'/admin/web.php';
