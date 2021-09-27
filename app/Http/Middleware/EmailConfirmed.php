<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;

class EmailConfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user instanceof MustVerifyEmail &&
            ! $user->hasVerifiedEmail()) {
            return redirect(route('blog.profile.confirmation-page', $user->id))
                ->withErrors('You should verify your email');
        }

        return $next($request);
    }
}
