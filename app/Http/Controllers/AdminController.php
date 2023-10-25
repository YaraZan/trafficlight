<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $logs = UserActivityLog::all();
        return Inertia::render('Admin/Index', ['logs' => $logs]);
    }

    public function users()
    {
        $users = User::all();
        return Inertia::render('Admin/Users', ['users' => $users]);
    }

    public function roles()
    {
        $roles = Role::all();
        return Inertia::render('Admin/Roles', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        // Create a new user
        $$user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Redirect or respond as needed
    }
}
