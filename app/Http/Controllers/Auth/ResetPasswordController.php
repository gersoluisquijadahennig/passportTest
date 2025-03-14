<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /*protected function setUserPassword($user, $password)
    {
        $user->clave = Hash::make($password);
    }*/

    public function reset(Request $request)
    {
        //dd(app('auth.password.broker'));
        //dd($request->all());

        $request->validate($this->rules(), $this->validationErrorMessages());

        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    protected function resetPassword($user, $password)
    {

        $this->setUserPassword($user, $password);

        //$user->setRememberToken(Str::random(60)); si se desea implementar a futuro

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    protected function validationErrorMessages()
    {
        return [
            "confirmed" => "Las contraseñas no coinciden validation errors",
        ];
    }

    protected function setUserPassword($user, $password)
    {
        $user->clave = Hash::make($password);
    }

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'correo_electronico' => $request->correo_electronico]
        );
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'correo_electronico' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'correo_electronico', 'password', 'password_confirmation', 'token'
        );
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {

        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'correo_electronico' => [trans($response)],
            ]);
        }

        return redirect()->back()
                    ->withInput($request->only('correo_electronico'))
                    ->withErrors(['correo_electronico' => trans($response)]);
    }

}
