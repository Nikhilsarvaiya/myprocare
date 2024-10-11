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
use App\Http\Controllers\Admin\StudentsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function (){
    Route::get('dashboard',[\App\Http\Controllers\Admin\DashboardController::class,'index'])->name('dashboard');

    Route::resource('users', UserController::class);

    Route::resource('students', StudentsController::class);

    Route::resource('events', EventController::class);

    Route::resource('deals', DealController::class);

    Route::resource('business-types', BusinessTypeController::class);

    Route::resource('food-types', FoodTypeController::class);

    Route::resource('restaurant-types', RestaurantTypeController::class);

    Route::resource('advertisements', AdvertisementController::class);

    // All Businesses
    Route::get('businesses',[BusinessController::class,'index'])->name('businesses.index');

    // Step 1 Basic Details
    Route::get('businesses/basic-details/create',[BusinessBasicDetailController::class,'create'])->name('businesses.basic_details.create');
    Route::post('businesses/basic-details',[BusinessBasicDetailController::class,'store'])->name('businesses.basic_details.store');

    Route::prefix('businesses/{business}')->name('businesses.')->group(function (){
        Route::get('/',[BusinessController::class,'show'])->name('show');
        Route::delete('/',[BusinessController::class,'destroy'])->name('destroy');

        // Step 1 Basic Details
        Route::get('basic-details/edit',[BusinessBasicDetailController::class,'edit'])->middleware(['admin_business_step'])->name('basic_details.edit');
        Route::put('basic-details',[BusinessBasicDetailController::class,'update'])->name('basic_details.update');

        // Step 2 Opening Hours
        Route::get('opening-hours/create',[BusinessOpeningHourController::class,'create'])->name('opening_hours.create');
        Route::match(['put', 'post'],'opening-hours',[BusinessOpeningHourController::class,'store'])->name('opening_hours.store');
        Route::get('opening-hours/edit',[BusinessOpeningHourController::class,'edit'])->middleware(['admin_business_step'])->name('opening_hours.edit');

        // Step 3 Links
        Route::get('links/create',[BusinessLinkController::class,'create'])->name('links.create');
        Route::match(['put', 'post'],'links',[BusinessLinkController::class,'store'])->name('links.store');
        Route::get('links/edit',[BusinessLinkController::class,'edit'])->middleware(['admin_business_step'])->name('links.edit');

        // Step 4 Profile & Banner
        Route::get('media/create',[BusinessMediaController::class,'create'])->name('media.create');
        Route::post('media',[BusinessMediaController::class,'store'])->name('media.store');
        Route::get('media/edit',[BusinessMediaController::class,'edit'])->middleware(['admin_business_step'])->name('media.edit');
        Route::put('media',[BusinessMediaController::class,'update'])->name('media.update');

        // Step 4 Restaurant Type & Food Type (For Food Business)
        Route::get('restaurant-type',[BusinessRestaurantTypeController::class,'create'])->name('restaurant_type.create');
        Route::match(['put', 'post'],'restaurant-type',[BusinessRestaurantTypeController::class,'store'])->name('restaurant_type.store');
        Route::get('restaurant-type/edit',[BusinessRestaurantTypeController::class,'edit'])->middleware(['admin_business_step'])->name('restaurant_type.edit');

        // Step 5 Menu Items (For Food Business)
        Route::get('menus/create-index',[BusinessMenuController::class,'createIndex'])->name('menus.create.index');
        Route::get('menus/edit-index',[BusinessMenuController::class,'editIndex'])->middleware(['admin_business_step'])->name('menus.edit.index');

        Route::match(['put', 'post'],'menus',[BusinessMenuController::class,'store'])->name('menus.store');
        Route::get('menus/{menu}/edit',[BusinessMenuController::class,'edit'])->name('menus.edit');
        Route::put('menus/{menu}',[BusinessMenuController::class,'update'])->name('menus.update');
        Route::delete('menus/{menu}',[BusinessMenuController::class,'destroy'])->name('menus.destroy');

        // Step 5 Product Items
        Route::get('products/create-index',[BusinessProductController::class,'createIndex'])->name('products.create.index');
        Route::get('products/edit-index',[BusinessProductController::class,'editIndex'])->middleware(['admin_business_step'])->name('products.edit.index');

        Route::match(['put', 'post'],'products',[BusinessProductController::class,'store'])->name('products.store');
        Route::get('products/{product}/edit',[BusinessProductController::class,'edit'])->name('products.edit');
        Route::put('products/{product}',[BusinessProductController::class,'update'])->name('products.update');
        Route::delete('products/{product}',[BusinessProductController::class,'destroy'])->name('products.destroy');

        Route::post('approve', [BusinessController::class, 'approve'])->name('approve');
    });

    Route::resource('road-closures', \App\Http\Controllers\Admin\RoadClosureController::class);

    Route::get('settings/wallet', [\App\Http\Controllers\Admin\Settings\WalletSettingsController::class, 'edit'])->name('settings.wallet.edit');
    Route::put('settings/wallet', [\App\Http\Controllers\Admin\Settings\WalletSettingsController::class, 'update'])->name('settings.wallet.update');

    ///Json
    Route::get('json/users', [\App\Http\Controllers\Admin\JsonController::class,'userEmailList']);
    Route::get('json/users-email', [\App\Http\Controllers\Admin\JsonController::class, 'usersEmail'])->name('json.users.email');
    Route::get('json/businesses-name', [\App\Http\Controllers\Admin\JsonController::class, 'businessesName'])->name('json.businesses.name');
});
