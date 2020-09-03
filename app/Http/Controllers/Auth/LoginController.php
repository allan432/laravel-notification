<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendLoginResponse(Request $request)
    {

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $role = auth()->user()->role;
        $redirectPath = route('dashboard');
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
        }

        return $this->authenticated($request, $this->guard()->user())
            // ?: redirect()->intended($this->redirectPath());
            ?: redirect()->intended($redirectPath);
    }
}
