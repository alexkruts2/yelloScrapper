<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!empty(auth()->guard('admin')->id())) {

            if (is_null(User::find(auth()->guard('admin')->id()))) {
                return redirect()->route('admin.login');
            }

            return $next($request);
        }
        else {
            return redirect()->route('admin.login');
        }
    }
}
