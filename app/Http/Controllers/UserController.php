<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::all();
        $usersPanel = \App\Models\UserAuth::all();
        return view('userIndex', compact('users','usersPanel'));
    }
}
