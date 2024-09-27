<?php

use App\Http\Controllers\User\BusinessOfferController;
use App\Http\Controllers\User\BusinessWalletTransactionController;
use App\Http\Controllers\User\DealController;
use App\Http\Controllers\User\EventController;
use App\Http\Controllers\User\RewardPointController;
use App\Http\Controllers\User\RewardPointTransactionController;
use App\Http\Controllers\User\WalletTransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Business\BusinessBasicDetailController;
use App\Http\Controllers\User\Business\BusinessController;
use App\Http\Controllers\User\Business\BusinessLinkController;
use App\Http\Controllers\User\Business\BusinessMediaController;
use App\Http\Controllers\User\Business\BusinessMenuController;
use App\Http\Controllers\User\Business\BusinessOpeningHourController;
use App\Http\Controllers\User\Business\BusinessProductController;
use App\Http\Controllers\User\Business\BusinessRestaurantTypeController;

Route::prefix('user')->name('user.')->middleware(['auth'])->group(function (){
    Route::get('dashboard', function (){ return view('user.dashboard'); })->name('dashboard');

});
