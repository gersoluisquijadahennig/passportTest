<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // get session id
        $sessionId = session()->getId();
        // get info from session
        $sessionInfo = session()->all();

        $user = auth()->user();
        //$cliente3 = Auth::guard('api:cliente3')->check();

        $clientes = [
            'cliente3' => false,
            'cliente2' => false
        ];

        if (Gate::allows('cliente_3', $user)) {
            $clientes['cliente3'] = true;
        }

        if (Gate::allows('cliente_2', $user)) {
            $clientes['cliente2'] = true;
        }

        $token = $user->token();

        //dump($token);

        //$user->withAccessToken($token);

       // obtener los scopes del token

        return view('account.dashboard', compact('sessionId', 'sessionInfo', 'user', 'clientes', 'token'));
    }

}
