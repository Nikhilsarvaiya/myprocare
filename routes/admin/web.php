<?php

use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\Business\BusinessBasicDetailController;
use App\Http\Controllers\Admin\Business\BusinessController;
use App\Http\Controllers\Admin\Business\BusinessLinkController;
use App\Http\Controllers\Admin\Business\BusinessMediaController;
use App\Http\Controllers\Admin\Business\BusinessMenuController;
use App\Http\Controllers\Admin\Business\BusinessOpeningHourController;
use App\Http\Controllers\Admin\Business\BusinessProductController;
use App\Http\Controllers\Admin\Business\BusinessRestaurantTypeController;
use App\Http\Controllers\Admin\BusinessTypeController;
use App\Http\Controllers\Admin\DealController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FoodTypeController;
use App\Http\Controllers\Admin\RestaurantTypeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function (){
    Route::get('dashboard',[\App\Http\Controllers\Admin\DashboardController::class,'index'])->name('dashboard');
});
