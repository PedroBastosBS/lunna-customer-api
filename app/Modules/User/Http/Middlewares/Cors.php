<?php

namespace App\Modules\User\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;

class Cors
{
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Authorization, X-User-Agent, Accept');
    
        return $response;
    }
}
