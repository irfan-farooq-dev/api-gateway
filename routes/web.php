<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    /*

    php artisan cache:clear
    php artisan config:clear
    php artisan config:cache

    */

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    // Artisan::call('view:clear');

    return "Cleared!";
});