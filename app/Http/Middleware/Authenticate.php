<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @return string|null
     */
    protected function redirectTo()
    {
        return '/blog/login';
    }

    public function handle(Request $request, Closure $next, $role = null)
    {
        if (!Auth::check()) {
            return $this->redirectTo();
        }

        if ($role === 'admin' && !Auth::user()->isAdmin()) {
            throw new UnauthorizedException('You have no rights to go through this');
        }

        return $next($request);
    }
}
