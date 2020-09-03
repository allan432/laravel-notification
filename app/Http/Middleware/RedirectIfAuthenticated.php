<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();

            $redirectPath = route('dashboard');

            $role = auth()->user()->role;
            $sourcing = $user['sourcing'];
            switch ($role) {

                case 'admin':
                    $redirectPath = route('admin.dashboard');
                    break;

                case 'accountant':
                    $redirectPath = route('accountant.dashboard');
                    break;

                case 'hr':
                    $redirectPath = route('hr.dashboard');
                    break;

                case 'recruiter':
                    if ($sourcing == null) {
                        $redirectPath = route('dashboard');
                    } else {
                        $redirectPath = route('recruiter.dashboard');
                    }
                    break;
            }

            return redirect($redirectPath);
        }
        return $next($request);
    }
}
