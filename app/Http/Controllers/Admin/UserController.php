<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'status' => $validated['status'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->roles()->sync([$validated['role_id']]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        $newRole = Role::findOrFail($validated['role_id']);

        // Check if user is currently a Super Admin
        if ($user->hasRole('super-admin')) {
            $activeSuperAdminsCount = User::where('status', 'active')
                ->whereHas('roles', fn($q) => $q->where('slug', 'super-admin'))
                ->count();

            $isDemoting = $newRole->slug !== 'super-admin';
            $isDeactivating = $validated['status'] === 'inactive';

            if (($isDemoting || $isDeactivating) && $activeSuperAdminsCount <= 1) {
                return redirect()->back()->with('error', 'Cannot demote or deactivate the last active Super Admin user.');
            }
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->status = $validated['status'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->roles()->sync([$validated['role_id']]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->hasRole('super-admin')) {
            $activeSuperAdminsCount = User::where('status', 'active')
                ->whereHas('roles', fn($q) => $q->where('slug', 'super-admin'))
                ->count();

            if ($activeSuperAdminsCount <= 1) {
                return redirect()->back()->with('error', 'Cannot delete the last active Super Admin account.');
            }
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
