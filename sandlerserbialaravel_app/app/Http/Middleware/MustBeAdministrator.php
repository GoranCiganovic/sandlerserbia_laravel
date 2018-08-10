<?php

namespace App\Http\Middleware;

use Closure;

class MustBeAdministrator
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
        $admin = $request->user()->is_admin;
        if ($admin) {
            return $next($request);
        }
        $request->session()->flash('message', "Nemate ovlašćenje za ovu akciju!");
        return back();
        //abort(403, "Nemate ovlašćenja za ovu akciju!");
    }
}
