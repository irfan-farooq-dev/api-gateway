<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::any('{any}', function ($any) {
        $url = config('services.auth') . '/api/' . $any;

        \Log::info('Forwarding to: ' . $url);

        // Clean headers: remove Host and Content-Length to avoid forwarding gateway-specific headers
        $headers = collect(request()->headers->all())
            ->except(['host', 'content-length'])
            ->map(function ($v) {
                return is_array($v) ? implode(', ', $v) : $v;
            })->toArray();

        try {
            $response = Http::withHeaders($headers)
                ->timeout(10) // seconds
                ->withOptions(['verify' => app()->environment('local') ? false : true])
                ->send(request()->method(), $url, [
                    'json'  => request()->all(),
                    'query' => request()->query(),
                ]);

            return response($response->body(), $response->status());
        } catch (\Exception $e) {
            \Log::error('Proxy error when forwarding to ' . $url . ': ' . $e->getMessage());
            return response('Upstream service unavailable', 502);
        }
    })->where('any', '.*');
});

Route::middleware('jwt')->prefix('profile')->group(function () {
    Route::any('{any}', function ($any) {
        $url = config('services.profile') . '/api/' . $any;

        // Clean headers and avoid forwarding Host
        $headers = collect(request()->headers->all())
            ->except(['host', 'content-length'])
            ->map(function ($v) {
                return is_array($v) ? implode(', ', $v) : $v;
            })->toArray();

        try {
            $response = Http::withHeaders($headers)
                ->timeout(10)
                ->withOptions(['verify' => app()->environment('local') ? false : true])
                ->send(request()->method(), $url, [
                    'json'  => request()->all(),
                    'query' => request()->query(),
                ]);
            return response($response->body(), $response->status());
        } catch (\Exception $e) {
            \Log::error('Proxy error when forwarding to ' . $url . ': ' . $e->getMessage());
            return response('Upstream service unavailable', 502);
        }
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

    return "ApiGateway Cleared!";
});
