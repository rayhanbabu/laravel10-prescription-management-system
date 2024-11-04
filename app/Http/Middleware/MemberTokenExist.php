<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\MemberJWTToken;
use Illuminate\Support\Facades\Cookie;

class MemberTokenExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token_member=Cookie::get('token_member');
        $result=MemberJWTToken::ReadToken($token_member);
         if($result=="unauthorized"){
             return $next($request);
         }else{
             return redirect('/member/dashboard');
         }
    }
}
