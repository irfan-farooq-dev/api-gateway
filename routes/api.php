<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::any('{any}', function ($any) {
        $url      = config('services.auth') . '/api/' . $any;
        $response = Http::withHeaders(request()->headers->all())
            ->send(request()->method(), $url, [
                'json' => request()->all(),
            ]);
        return response($response->body(), $response->status());
    })->where('any', '.*');
});

Route::middleware('jwt')->prefix('profile')->group(function () {
    Route::any('{any}', function ($any) {
        $url      = config('services.profile') . '/' . $any;
        $response = Http::withHeaders(request()->headers->all())
            ->send(request()->method(), $url, [
                'json' => request()->all(),
            ]);
        return response($response->body(), $response->status());
    })->where('any', '.*');
});

Route::get('/clear', function () {

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
