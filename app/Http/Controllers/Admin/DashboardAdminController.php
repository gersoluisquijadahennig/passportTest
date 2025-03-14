<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Realm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request){

        $realm = $request->current_realm;

        return Inertia::render('Admin/Dashboard/Index', [
            'realm' => $realm
        ]);
    }
}