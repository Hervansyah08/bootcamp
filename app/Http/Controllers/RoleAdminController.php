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

    public function edit(User $user) //menggunakan route model binding
    {
        return view('pages.role.admin.admin_edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
        ]);


        // Update data program
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Redirect ke halaman program dengan pesan sukses
        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(User $user) //menggunakan route model binding
    {
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');

        // Cek apakah keyword kosong
        if (empty($keyword)) {
            // Jika kosong, ambil semua data dengan role super_admin
            $users = User::where('role', 'admin')
                ->paginate(5);
        } else {
            // Jika tidak kosong, lakukan pencarian hanya pada user dengan role super_admin
            $users = User::where('role', 'admin')
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', "%" . $keyword . "%")
                        ->orWhere('email', 'like', "%" . $keyword . "%");
                })
                ->paginate(5)
                ->withQueryString();
        }

        return view('pages.role.admin.admin_index', compact('users'));
    }
}
