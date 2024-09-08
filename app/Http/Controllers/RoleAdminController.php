<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RoleAdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'admin')
            ->paginate(5);

        return view('pages.role.admin.admin_index', compact('users'));
    }

    public function create()
    {
        return view('pages.role.admin.admin_create');
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
            'role' => 'admin',
            'password' => Hash::make($validatedData['password']),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil dibuat dan email telah diverifikasi.');
    }
}
