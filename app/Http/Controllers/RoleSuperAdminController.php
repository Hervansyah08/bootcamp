<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RoleSuperAdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'super_admin')
            ->paginate(5);

        return view('pages.role.super_admin.index', compact('users'));
    }

    public function create()
    {
        return view('pages.role.super_admin.create');
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
            'role' => 'super_admin',
            'password' => Hash::make($validatedData['password']),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('super-admin.index')->with('success', 'Super Admin berhasil dibuat dan email telah diverifikasi.');
    }
}
