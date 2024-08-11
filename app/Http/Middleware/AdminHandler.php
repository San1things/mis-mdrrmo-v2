<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->session()->has('sessionkey')){ //session()->missing('key) is not working
            return redirect()->route('loginpage', ['alert' => 2]);
        }

        $value = $request->session()->get('sessionkey');
        $decryptedvalue = decrypt($value);
        $userinfo = explode(',' , $decryptedvalue);

        if($userinfo[4] != 'admin' && $userinfo[4] != 'staff'){
            return redirect()->route('loginpage', ['alert' => 3]);
            die();
        }

        $request->attributes->add(['userinfo' => $userinfo]);

        return $next($request);
    }
}
