<?php

namespace App\Http\Middleware;

use  Closure;
use Illuminate\Http\Request;
use App\Trait\ResponseTrait;

class CheckIfUser
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || $user->type !== 'user') {
            return $this->res(false, 'Access denied. You do not have user permissions.', 403);
        }

        return $next($request);
    }
}
