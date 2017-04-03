<?php

namespace App\Http\Middleware;

use Closure;

class checkInstall
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
        $env = env('INSTALL');
        if($env == null)
        {
            return redirect('/install');
        }
        return $next($request);
        
        
    }
}
