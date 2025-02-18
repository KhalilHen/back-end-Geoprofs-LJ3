<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('OPTIONS'))
        {
            $response = new Response();
        }
        else 
        {
            $response = $next($request);
        }

        $response->headers->set('Access-Control-Allow-Origin', '*'); //front end url should replace *
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        // $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
