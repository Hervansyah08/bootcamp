<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RoleUserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
            ->paginate(5);

        return view('pages.role.user.user_index', compact('users'));
    }

    public function create()
    {
        return view('pages.role.user.user_create');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // mengasumsikan konfirmasi password diperlukan
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => 'user',
            'password' => Hash::make($validatedData['password']),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dibuat dan email telah diverifikasi.');
    }

    public function edit(User $user) //menggunakan route model binding
    {
        return view('pages.program.program_edit', compact('user'));
    }
}
