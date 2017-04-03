<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminMiddleware
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
        if (Auth::user()->role == 0 && Auth::check() && Auth::user()->id == 1) {
            $trim_if_string = function ($var) { return is_string($var) ? trim($var) : $var; };
            $request->merge(array_map( $trim_if_string , $request->all()));
            return $next($request);
        }
        return redirect('/');
    }
}
