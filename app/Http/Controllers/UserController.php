<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;


class UserController extends Controller
{
    // List all users
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    // Show form to create a user
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // Store a new user
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name'     => 'required|string|max:255',
    //         'email'    => 'required|email|unique:users',
    //         'password' => 'required|string|min:6|confirmed',
    //         'role'     => 'nullable|exists:roles,name',
    //     ]);

    //     $user = User::create([
    //         'name'     => $validated['name'],
    //         'email'    => $validated['email'],
    //         'password' => bcrypt($validated['password']),
    //     ]);

    //     if ($validated['role']) {
    //         $user->assignRole($validated['role']);
    //     }

    //     return redirect()->route('users.index')->with('success', 'User created successfully.');
    // }


    public function store(StoreUserRequest $request)
{
    $validated = $request->validated();

    $user = User::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    if (!empty($validated['role'])) {
        $user->assignRole($validated['role']);
    }

    return redirect()->route('users.index')->with('success', 'User created successfully.');
}

    // Show form to edit user
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // Update user
    // public function update(Request $request, User $user)
    // {
    //     $validated = $request->validate([
    //         'name'     => 'required|string|max:255',
    //         'email'    => 'required|email|unique:users,email,' . $user->id,
    //         'password' => 'nullable|string|min:6|confirmed',
    //         'role'     => 'nullable|exists:roles,name',
    //     ]);

    //     $user->update([
    //         'name'     => $validated['name'],
    //         'email'    => $validated['email'],
    //         'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
    //     ]);

    //     if ($validated['role']) {
    //         $user->syncRoles([$validated['role']]);
    //     }

    //     return redirect()->route('users.index')->with('success', 'User updated successfully.');
    // }


    public function update(UpdateUserRequest $request, User $user)
{
    $validated = $request->validated();

    $user->update([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => !empty($validated['password']) ? bcrypt($validated['password']) : $user->password,
    ]);

    if (!empty($validated['role'])) {
        $user->syncRoles([$validated['role']]);
    }

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted.');
    }





     // View a user's borrowed books
     public function viewBorrowings($id)
     {
         $user = User::with('lendingRecords.book')->findOrFail($id);
         return view('users.borrowings', compact('user'));
     }
 
    

public function show(User $user)
{
    $borrowings = $user->lendings()->with('book')->latest()->get();

    return view('users.show', compact('user', 'borrowings'));
}


}
