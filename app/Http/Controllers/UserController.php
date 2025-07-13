<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // Import Role model
use App\Http\Controllers\UserController; // Tambahkan ini jika belum ada

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage users']); // Hanya user dengan permission ini yang bisa akses
    }

    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user->update($request->only('name', 'email'));
        $user->syncRoles($request->roles); // Sync roles

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui dan role diatur.');
    }

    public function destroy(User $user)
    {
        // Pastikan super admin tidak menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->withErrors('Tidak bisa menghapus akun Anda sendiri.');
        }

        // Hapus juga role-nya terlebih dahulu
        $user->syncRoles([]);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}