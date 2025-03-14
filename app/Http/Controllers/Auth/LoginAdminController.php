<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginAdminController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/admin/master/dashboard';

    public function __construct()
    {
        $this->middleware(['guest:admin'])->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    public function username()
    {
        return 'rut';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        //dd(bcrypt($request->password));

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => "la combinación de usuario y contraseña no es correcta.",
        ]);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('admin/login');
    }

    public function redirectTo()
    {
        $current_realm = request()->get('current_realm');

        if ($current_realm) {
            return "/admin/{$current_realm}/dashboard";
        }
        return '/admin/master/dashboard';
    }
}
