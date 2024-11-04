<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class MixedMiddleware
{
    /** 
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       
       if(mixed_access()) {
            // Allow the request to proceed if the user is authenticated and is an Admin
            return $next($request);
       }
        
        return redirect('/login');  
    }
}
