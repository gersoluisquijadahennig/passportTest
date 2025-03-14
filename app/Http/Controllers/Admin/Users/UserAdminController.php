<?php

namespace App\Http\Controllers\Admin\Users;
use Inertia\Inertia;
use App\Models\UserAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserAdminController extends Controller
{
    public function create(Request $request)
    {
        $realm = $request->current_realm;
        return Inertia::render('Admin/Users/Create',[
            'realm' => $realm
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'run' => 'required',
        ]);

        $user = new UserAdmin();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->rut = $request->run;
        $user->first_name = $request->name;
        $user->alias = $request->name.'.'.$request->first_name;
        $user->save();

        $user->realms()->attach($request->current_realm);

        return redirect()->route('admin.user.create')->with('success', 'User created successfully.');
    }

    public function index(Request $request)
    {
        $realm = $request->current_realm;
        $users =  $realm->users;

        return Inertia::render('Admin/Users/Index',[
            'realm' => $realm,
            'users' => $users
        ]);

    }

    public function getUsers()
    {
        $realm = request()->current_realm;

        return response()->json($realm->users);
    }
}