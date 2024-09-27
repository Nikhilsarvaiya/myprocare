<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScrapingController;
use Illuminate\Support\Facades\Route;


Route::get('/v1/scraping/scrape-quotes', [ScrapingController::class, 'scrapeQuotes']);


Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

require __DIR__.'/user/web.php';

require __DIR__.'/admin/web.php';
