<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo(Request $request)
    {
        return '/blog/login';
    }

    public function handle(Request $request, Closure $next, $role = null)
    {
        $userIsNotLoggedIn = !Auth::check();

        if ($userIsNotLoggedIn) return redirect('/blog/login');

        if ($role === 'admin' && !Auth::user()->isAdmin()) {
            return $this->logout();
        }

        return $next($request);
    }


    public function logout()
    {
        Auth::logout();

        return redirect('/blog/login')
            ->with(['status' => 'You have no access to this page']);
    }
}
