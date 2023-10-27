<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserCreateRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\Ngdu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(): Response
    {
        $users = DB::table('users as usr')
        ->join('roles as r', 'usr.role_id', '=', 'r.id')
        ->join('Ngdu as n', 'usr.ngdu_id', '=', 'n.Id')
        ->select([
            'usr.public_id',
            'usr.name',
            'usr.email',
            'usr.role_id',
            'usr.ngdu_id',
            'r.name as roleName',
            'n.NgduName as ngduName',
        ])
        ->orderBy('usr.created_at')
        ->get();

        $roles = Role::all();
        $ngdus = Ngdu::all();

        return Inertia::render('Users/Index', [
            'users' => $users,
            'roles' => $roles,
            'ngdus' => $ngdus
        ]);
    }

    public function store(UserCreateRequest $request): RedirectResponse
    {
        $publicId = Str::uuid();

        // Create a new user
        $user = new User;
        $user->public_id = $publicId;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');
        $user->ngdu_id = $request->input('ngdu_id');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Redirect or respond as needed
        return Redirect::route('users');
    }

    public function update(UserUpdateRequest $request): RedirectResponse
    {
        $request->validate([
            'confirm_password' => ['required', 'current_password'],
        ]);

        $public_id = $request->input('public_id');
        $user = User::where('public_id', '=', $public_id)->first();
    
        $new_role = Role::find($request->input('role_id'));
        $new_ngdu = Ngdu::find($request->input('ngdu_id'));
    
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
    
        $user->role_id = $new_role->id;
        $user->ngdu_id = $new_ngdu->Id;

        $user->save();
    
        return Redirect::route('users');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'confirm_password' => ['required', 'current_password'],
        ]);
        
        $public_id = $request->input('public_id');

        $user = User::where('public_id', '=', $public_id)->first();

        $user->delete();

        // Redirect or respond as needed
        return Redirect::route('users');
    }
}
