<?php

namespace Zeus\Http\Middlewares;

use Closure;

class ZeusGateWayMiddleware
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
        return auth()->user()->hasPermission('browse_admin') ? $next($request) : abort(403);
    }
}
