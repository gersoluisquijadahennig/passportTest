<?php

namespace App\Http\Controllers\Auth;

use App\Rules\Rut;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;



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

    protected $redirectTo = '/account/dashboard';

    protected $maxAttempts = 2;

    protected $decayMinutes = 1;

    public function __construct()
    {
        $this->middleware('guest')
        ->except('logout');
    }
    public function username()
    {
        return 'run';
    }
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => "la combinación de usuario y contraseña no es correcta.",
        ]);
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $key = $this->throttleKey($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            \Log::info('Has too many login attempts', ['key' => $key, 'attempts' => $this->limiter()->attempts($key)]);
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
                $request->session()->flash('status', 'Sesión iniciada correctamente');
            }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        \Log::info('Failed login attempt', ['key' => $key, 'attempts' => $this->limiter()->attempts($key)]);

        return $this->sendFailedLoginResponse($request);
    }
    protected function authenticated(Request $request, $user)
    {
        $request->session()->regenerateToken(); // Regenera el token CSRF sin cerrar la sesión del otro guard
    }
    // determinar los scopes del usuario para mostrar las opciones del menú de aplicaciones
    protected function scopesForUser($user)
    {
        $scopes = [];
        if ($user->hasRole('admin')) {
            //
        }
            $scopes = array_merge($scopes, $user->hasApp());
            $scopes = array_values(array_unique($scopes));

        return $scopes;
    }
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => ['required', 'string', new Rut],
            'password' => 'required|string',
        ],
        [
            'run.required' => 'El campo rut es obligatorio',
            'password.required' => 'El campo contraseña es obligatorio',
        ]);
    }
    protected function incrementLoginAttempts(Request $request)
    {
        $attempts = $this->limiter()->attempts($this->throttleKey($request));
        $this->limiter()->hit(
            $this->throttleKey($request), $this->dynamicDecayMinutes($attempts) * 60
        );
    }
    protected function dynamicDecayMinutes($attempts)
    {
        \Log::info('Dynamic decay minutes', ['attempts' => $attempts]);
        if ($attempts >= 10) {
            return 10; // 10 minutes for 10 or more attempts
        } elseif ($attempts >= 5) {
            return 1; // 1 minute for 5 or more attempts
        }
        return $this->decayMinutes(); // default decay minutes
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
            : redirect('/account/login');
    }

    public function showLoginForm()
    {
        return view('auth.account.login');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}
