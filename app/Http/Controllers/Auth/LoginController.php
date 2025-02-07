<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;
use Illuminate\Validation\ValidationException;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
    public function revoke(Request $request){

        //dd($request->user());
        try {
            $user = $request->user();

            $tokenId = $user->token()->id;
            $tokenRepository = app(TokenRepository::class);
            $refreshTokenRepository = app(RefreshTokenRepository::class);

            // Revocar el token de acceso
            $tokenRepository->revokeAccessToken($tokenId);
            // Revocar todos los tokens de actualización asociados
            $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

            return response()->json([
                'message' => 'Token y sesión web revocados correctamente.'
            ], 200);
        } catch (\Exception $e) {
            // Manejo de excepciones generales
            return response()->json([
                'error' => 'Ocurrió un error al revocar el token y cerrar la sesión. ' . $e->getMessage()
            ], 500);
        }
    }


}
