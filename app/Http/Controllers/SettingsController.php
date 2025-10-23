<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:view_settings');
    }

    public function index()
    {
        $users = User::with('roles')->get();
        return view('settings.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create_users');
        return view('settings.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create_users');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:anggota,bendahara'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('settings.index')
            ->with('success', 'User berhasil dibuat!');
    }

    public function edit(User $user)
    {
        $this->authorize('edit_users');
        $user->load('roles');
        return view('settings.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('edit_users');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:anggota,bendahara'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('settings.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete_users');
        if ($user->id === auth()->id()) {
            return redirect()->route('settings.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('settings.index')
            ->with('success', 'User berhasil dihapus!');
    }

    public function resetPassword(User $user)
    {
        // Check if user has edit_users permission
        if (!auth()->user()->can('edit_users')) {
            return redirect()->route('settings.index')
                ->with('error', 'Anda tidak memiliki permission untuk mengedit user!');
        }

        return view('settings.reset-password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        // Check if user has edit_users permission
        if (!auth()->user()->can('edit_users')) {
            return redirect()->route('settings.index')
                ->with('error', 'Anda tidak memiliki permission untuk mengedit user!');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Password berhasil direset!');
    }

    // Role Management Methods
    public function roles()
    {
        $this->authorize('view_users');
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('settings.roles', compact('roles', 'permissions'));
    }

    public function createRole()
    {
        $this->authorize('create_users');
        $permissions = Permission::all();
        return view('settings.create-role', compact('permissions'));
    }

    public function storeRole(Request $request)
    {
        $this->authorize('create_users');
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions);

        return redirect()->route('settings.roles')
            ->with('success', 'Role berhasil dibuat!');
    }

    public function editRole(Role $role)
    {
        $this->authorize('edit_users');
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('settings.edit-role', compact('role', 'permissions', 'rolePermissions'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $this->authorize('edit_users');
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('settings.roles')
            ->with('success', 'Role berhasil diperbarui!');
    }

    public function destroyRole(Role $role)
    {
        $this->authorize('delete_users');
        if ($role->name === 'bendahara' || $role->name === 'anggota') {
            return redirect()->route('settings.roles')
                ->with('error', 'Tidak dapat menghapus role default!');
        }

        $role->delete();

        return redirect()->route('settings.roles')
            ->with('success', 'Role berhasil dihapus!');
    }
}
