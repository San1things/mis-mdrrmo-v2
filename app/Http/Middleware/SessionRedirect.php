<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('sessionkey')) {
            $value = $request->session()->get('sessionkey');
            $decryptedvalue = decrypt($value);
            $userinfo = explode(',', $decryptedvalue);
            if ($userinfo[4] === 'admin' || $userinfo[4] === 'staff') {
                return redirect('/users');
            } else if ($userinfo[4] === 'resident') {
                return redirect('/userhome');
            }
        }

        return $next($request);
    }
}
