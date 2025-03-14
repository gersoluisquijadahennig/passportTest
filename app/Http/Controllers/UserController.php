<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::all();
        return view('userIndex', compact('users','usersPanel'));
    }

    public function enviarCorreo(Request $request)
    {
        Mail::mailer('smtp')->raw('Su solicitud de cambio de director a sido confirmada, Ingrese a nuestra plataforma desde www.ssbiobio.cl, no olvidar tener activada su Claveúnica(https://claveunica.gob.cl/).', function ($message) {
            $message->to(['gersoluisquijadahennig@gmail.com'], 'gerso quijada')
                ->subject("Confirmacion cambio de director(TAMBORIN)");
        });
    }
}
