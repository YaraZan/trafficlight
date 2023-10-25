<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\RoleCreateRequest;
use App\Http\Requests\Roles\RoleUpdateRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(): Response
    {
        $roles = Role::all();
        return Inertia::render('Roles/Index', ['roles' => $roles]);
    }

    public function store(RoleCreateRequest $request): RedirectResponse
    {
        $publicId = Str::uuid();

        // Create a new role
        $role = new Role();
        $role->public_id = $publicId;
        $role->name = $request->input('name');
        $role->canEdit = $request->input('can_edit');
        $role->canViewAll = $request->input('can_view_all');
        $role->save();

        // Redirect or respond as needed
        return Redirect::route('roles');
    }

    public function update(RoleUpdateRequest $request): RedirectResponse
    {
        $id = $request->input('id');

        $role = Role::find($id);

        $role->update([
            'name' => $request->input('name'),
            'canEdit' => $request->input('can_edit'),
            'canViewAll' => $request->input('can_view_all'),
        ]);

        return Redirect::route('roles');
    }

    public function destroy(Request $request): RedirectResponse
    {
        // Delete the role
        $role = Role::find($request->input('id'));

        $role->delete();

        // Redirect or respond as needed
        return Redirect::route('roles');
    }

}
