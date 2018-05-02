<?php

namespace App\Http\Middleware;

use Closure;

class MustBeAllowed
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
        $unauthorized = $request->user()->is_unauthorized;
        if($unauthorized){
            abort(403, "Nemate pravo pristupa!");
        }
        return $next($request);
         
    }
}
