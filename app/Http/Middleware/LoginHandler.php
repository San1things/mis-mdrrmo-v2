<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LoginHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('sessionkey')) {
            return redirect()->route('loginpage', ['alert' => 2]);
        }

        $value = $request->session()->get('sessionkey');
        $decryptedvalue = decrypt($value);
        $userinfo = explode(',', $decryptedvalue);
        $request->attributes->add(['userinfo' => $userinfo]);

        return $next($request);
    }
}
