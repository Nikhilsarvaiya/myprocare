<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScrapingController;
use Illuminate\Support\Facades\Route;


Route::get('/v1/scraping/scrape-quotes', [ScrapingController::class, 'scrapeQuotes']);
Route::get('/v1/scraping/scrape-data', [ScrapingController::class, 'scrapeData']);
Route::get('/scrape-login', [ScrapingController::class, 'scrapeLogin']);
Route::get('/scrape-with-login', [ScrapingController::class, 'scrapeWithLogin']);
Route::get('/api-login', [ScrapingController::class, 'getLoginApiData']);
Route::get('/api-report', [ScrapingController::class, 'apiReport']);


Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

require __DIR__.'/user/web.php';

require __DIR__.'/admin/web.php';
