<?php
namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API Gateway",
 *     version="1.0",
 *     description="Gateway endpoints that proxy to auth and profile microservices"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter token as: Bearer <token>"
 * )
 */
class ApiGatewayDocsController extends Controller
{
    /**
     * Generic proxy to auth microservice
     *
     * @OA\PathItem(path="/api/auth/{any}")
     *
     * @OA\Get(
     *     path="/api/auth/{any}",
     *     summary="Proxy GET requests to Auth service",
     *     @OA\Parameter(name="any", in="path", required=true, description="Path on auth service (e.g. 'login' or 'users/1')", @OA\Schema(type="string")),
     *     @OA\Parameter(name="Authorization", in="header", required=false, @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Successful response", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response="default", description="Error response")
     * )
     *
     * @OA\Post(
     *     path="/api/auth/{any}",
     *     summary="Proxy POST requests to Auth service",
     *     @OA\Parameter(name="any", in="path", required=true, description="Path on auth service (e.g. 'register')", @OA\Schema(type="string")),
     *     @OA\Parameter(name="Authorization", in="header", required=false, @OA\Schema(type="string")),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\MediaType(mediaType="application/json", @OA\Schema(type="object", additionalProperties=true))
     *     ),
     *     @OA\Response(response="200", description="Successful response", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response="default", description="Error response")
     * )
     */
    public function authProxy()
    {
        // This method exists purely so swagger-php can pick up the annotations.
    }

    /**
     * Generic proxy to profile microservice (requires JWT)
     *
     * @OA\PathItem(path="/profile/{any}")
     *
     * @OA\Get(
     *     path="/profile/{any}",
     *     summary="Proxy GET requests to Profile service",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="any", in="path", required=true, description="Path on profile service (e.g. 'me' or 'users/1')", @OA\Schema(type="string")),
     *     @OA\Parameter(name="Authorization", in="header", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Successful response", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="default", description="Error response")
     * )
     *
     * @OA\Post(
     *     path="/profile/{any}",
     *     summary="Proxy POST requests to Profile service",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="any", in="path", required=true, description="Path on profile service", @OA\Schema(type="string")),
     *     @OA\Parameter(name="Authorization", in="header", required=true, @OA\Schema(type="string")),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\MediaType(mediaType="application/json", @OA\Schema(type="object", additionalProperties=true))
     *     ),
     *     @OA\Response(response="200", description="Successful response", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="default", description="Error response")
     * )
     */
    public function profileProxy()
    {
        // No runtime behavior; annotations only
    }

    /**
     * Clear caches
     *
     * @OA\Get(
     *     path="/clear",
     *     summary="Clear application caches",
     *     @OA\Response(response="200", description="Cleared message", @OA\MediaType(mediaType="text/plain"))
     * )
     */
    public function clear()
    {
        // Documented but actual route implemented in routes/api.php
    }
}
