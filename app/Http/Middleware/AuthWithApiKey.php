<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class AuthWithApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = Crypt::decryptString($request->header('X-Auth-Key-Integration'));
        if($key !== env('AUTH_KEY_INTEGRATION')) {
            return response()->json(['error' => 'Unauthorized'], HttpResponse::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
