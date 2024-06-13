<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    //
    public function view()
    {
        return Inertia::render('Admin/Index');
    }

    public function getUsers() {
        $users = User::with(['ngdu', 'role'])->all();

        return response()->json($users);
    }

    public function getRoles() {
        $roles = Role::all();

        return response()->json($roles);
    }

    public function getLogs() {
        Log::whereDate( 'created_at', '<=', now()->subDays(90))->delete();

        $logs = Log::with(['user', 'status'])->orderBy('created_at','desc')->take(2000)->get();

        return response()->json($logs);
    }
}
