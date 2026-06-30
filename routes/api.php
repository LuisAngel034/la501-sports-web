<?php

use App\Http\Controllers\Api\PublicDataController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/public')
    ->middleware('throttle:public-api')
    ->controller(PublicDataController::class)
    ->group(function () {
        Route::get('/info', 'info')->name('api.public.info');
        Route::get('/products', 'products')->name('api.public.products');
        Route::get('/promotions', 'promotions')->name('api.public.promotions');
        Route::get('/news', 'news')->name('api.public.news');
        Route::get('/search', 'search')->name('api.public.search');
    });