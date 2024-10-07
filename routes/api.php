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
Route::get('business-types/{businessType}',[\App\Http\Controllers\Api\User\BusinessTypeController::class, 'show']);

Route::get('food-types',[\App\Http\Controllers\Api\User\FoodTypeController::class,'index']);
Route::get('food-types/{foodType}',[\App\Http\Controllers\Api\User\FoodTypeController::class, 'show']);

Route::get('restaurant-types',[\App\Http\Controllers\Api\User\RestaurantTypeController::class,'index']);
Route::get('restaurant-types/{restaurantType}',[\App\Http\Controllers\Api\User\RestaurantTypeController::class, 'show']);

Route::get('advertisements', [\App\Http\Controllers\Api\User\AdvertisementController::class, 'index']);
Route::get('advertisements/{advertisement}', [\App\Http\Controllers\Api\User\AdvertisementController::class, 'show']);

Route::get('businesses',[\App\Http\Controllers\Api\User\BusinessController::class,'index']);
Route::get('businesses/{business}',[\App\Http\Controllers\Api\User\BusinessController::class,'show']);
Route::get('all-businesses',[\App\Http\Controllers\Api\User\BusinessController::class,'allBusiness']);

Route::get('all-events', [\App\Http\Controllers\Api\User\EventController::class, 'all']);
Route::get('events/{event}', [\App\Http\Controllers\Api\User\EventController::class, 'show']);

Route::get('all-deals', [\App\Http\Controllers\Api\User\DealController::class, 'all']);
Route::get('deals/{deal}', [\App\Http\Controllers\Api\User\DealController::class, 'show']);

Route::get('all-business-offers', [\App\Http\Controllers\Api\User\BusinessOfferController::class, 'all']);
Route::get('business-offers/{business_offer}', [\App\Http\Controllers\Api\User\BusinessOfferController::class, 'show']);

Route::get('all-road-closures', [\App\Http\Controllers\Api\User\RoadClosureController::class, 'all']);
Route::get('road-closures/{road_closure}', [\App\Http\Controllers\Api\User\RoadClosureController::class, 'show']);


Route::middleware('guest')->group(function (){

    Route::post('register',[\App\Http\Controllers\Api\Auth\RegisteredUserController::class,'store']);

    Route::post('login',[\App\Http\Controllers\Api\Auth\AuthenticatedController::class,'store']);

    Route::post('forgot-password', [\App\Http\Controllers\Api\Auth\ForgotPasswordController::class, 'store']);

    Route::put('reset-password', [\App\Http\Controllers\Api\Auth\ForgotPasswordController::class, 'update']);
});


Route::middleware('auth:sanctum')->group(function (){

    Route::post('verify-email', \App\Http\Controllers\Api\Auth\VerifyEmailController::class)
        ->middleware(['throttle:6,1']);

    Route::post('email/verification-notification', [\App\Http\Controllers\Api\Auth\EmailVerificationNotificationController::class, 'store'])
        ->middleware(['throttle:6,1']);

    Route::put('password', [\App\Http\Controllers\Api\Auth\PasswordController::class, 'update']);

    Route::post('logout',[\App\Http\Controllers\Api\Auth\AuthenticatedController::class,'destroy']);

    Route::get('profile', [\App\Http\Controllers\Api\User\ProfileController::class,'index']);
    Route::put('profile', [\App\Http\Controllers\Api\User\ProfileController::class,'update']);

    Route::get('my-qr', [\App\Http\Controllers\Api\User\ProfileController::class, 'myQr']);

    Route::apiResource('events', \App\Http\Controllers\Api\User\EventController::class)->except(['show']);

    Route::apiResource('deals', \App\Http\Controllers\Api\User\DealController::class)->except(['show']);

    Route::apiResource('business-offers', \App\Http\Controllers\Api\User\BusinessOfferController::class)->except(['show']);

    Route::apiResource('road-closures', \App\Http\Controllers\Api\User\RoadClosureController::class)->except(['show']);

    Route::get('wallet', [\App\Http\Controllers\Api\User\WalletController::class, 'index']);
    Route::get('wallet-transactions', [\App\Http\Controllers\Api\User\WalletTransactionController::class, 'index']);

    Route::post('wallet-transactions/deposit', [\App\Http\Controllers\Api\User\WalletTransactionController::class, 'deposit']);
    Route::post('wallet-transactions/withdraw', [\App\Http\Controllers\Api\User\WalletTransactionController::class, 'withdraw']);
    Route::post('wallet-transactions/send', [\App\Http\Controllers\Api\User\WalletTransactionController::class, 'send']);

    Route::post('businesses/basic-details',[BusinessBasicDetailController::class,'store']);

    Route::prefix('businesses/{business}')->middleware(['can_manage_business'])->group(function (){
        Route::put('basic-details',[BusinessBasicDetailController::class,'update']);

        Route::match(['put', 'post'],'opening-hours',[BusinessOpeningHourController::class,'store']);

        Route::match(['put', 'post'],'links',[BusinessLinkController::class,'store']);

        Route::post('media',[BusinessMediaController::class,'store']);
        Route::put('media',[BusinessMediaController::class,'update']);

        Route::match(['put', 'post'],'restaurant-type',[BusinessRestaurantTypeController::class,'store']);

        Route::get('products',[BusinessProductController::class,'index'])->withoutMiddleware(['auth:sanctum', 'can_manage_business']);
        Route::post('products',[BusinessProductController::class,'store']);
        Route::get('products/{product}',[BusinessProductController::class,'show'])->withoutMiddleware(['auth:sanctum', 'can_manage_business']);
        Route::put('products/{product}',[BusinessProductController::class,'update'])->middleware(['can_manage_product']);
        Route::delete('products/{product}',[BusinessProductController::class,'destroy'])->middleware(['can_manage_product']);

        Route::get('menus',[BusinessMenuController::class,'index'])->withoutMiddleware(['auth:sanctum', 'can_manage_business']);
        Route::post('menus',[BusinessMenuController::class,'store']);
        Route::get('menus/{menu}',[BusinessMenuController::class,'show'])->withoutMiddleware(['auth:sanctum', 'can_manage_business']);
        Route::put('menus/{menu}',[BusinessMenuController::class,'update'])->middleware(['can_manage_menu']);
        Route::delete('menus/{menu}',[BusinessMenuController::class,'destroy'])->middleware(['can_manage_menu']);
    });

});


