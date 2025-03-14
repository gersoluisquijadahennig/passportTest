<?php

namespace App\Http\Controllers\Admin\Realms;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Realm;
use App\Models\UserAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;


class RealmAdminController extends Controller
{

    public function index()
    {
        return Inertia::render('Admin/Realms/Index', [
           'realms' => Realm::orderBy('id', 'asc')->get()
        ]);
    }
    public function create()
    {
        return Inertia::render('Admin/Realms/Create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'active' => 'required',
        ]);

        $realm = new Realm();
        $realm->name = $request->name;
        $realm->description = $request->description;
        $realm->active = $request->active;
        $realm->slug = strtolower($request->name);

        $realm->save();

        $realm->users()->attach(Auth::user()->id);

        return response()->json(['success' => 'Realm created successfully.', 'realm' => $realm]);
    }

    public function edit(Realm $realm)
    {
        return Inertia::render('Admin/Realms/Edit', [
            'realm' => $realm
        ]);
    }

    public function update(Request $request, Realm $realm)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'active' => 'required',
        ]);

        $realm->name = $request->name;
        $realm->description = $request->description;
        $realm->active = $request->active;
        $realm->save();

        return redirect()->route('admin.realm.index')->with('success', 'Realm updated successfully.');
    }

    public function destroy(Realm $realm)
    {
        $realm->delete();

        return redirect()->route('admin.realm.index')->with('success', 'Realm deleted successfully.');
    }

    public function getRealms()
    {
        return response()->json(Realm::orderBy('id', 'asc')->get());
    }



}
