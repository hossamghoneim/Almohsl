<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UpdateAdminCache
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if ( auth()->user()['needs_to_clear_cache'] )
        {
            cache()->flush();

            auth()->user()->update([
                'needs_to_clear_cache' => false
            ]);

        }

        return $next($request);
    }
}
