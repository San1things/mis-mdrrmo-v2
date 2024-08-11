<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->session()->has('sessionkey')){
            return redirect()->route('home', ['alert' => 2]);
            die();
        }

        $value = $request->session()->get('sessionkey');
        $decryptedvalue = decrypt($value);
        $userinfo = explode(',' , $decryptedvalue);

        if($userinfo[4] != 'resident'){
            return redirect()->route('loginpage' ,['alert' => 3]);
            die();
        }

        $request->attributes->add(['userinfo' => $userinfo]);

        return $next($request);
    }
}
