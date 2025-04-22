<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRolePermissionController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'permissions'])->get();
        return view('admin.user_roles.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.user_roles.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'array|nullable',
            'roles.*' => 'exists:roles,name',
            'permissions' => 'array|nullable',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $user->syncRoles($validated['roles'] ?? []);
        $user->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('user-role.index')->with('success', 'Roles and permissions updated.');
    }
}
