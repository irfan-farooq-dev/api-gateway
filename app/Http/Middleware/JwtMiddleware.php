<?php
namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        $authHeader = $request->header('Authorization');
        if (! $authHeader || ! str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = substr($authHeader, 7);
        try {
            $publicKey = cache()->remember('auth_public_key', 3600, function () {
                $response = Http::get(config('services.auth') . '/api/public-key');
                return $response->json('public_key');
            });

            $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));

            $request->attributes->set('user', $decoded);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}
