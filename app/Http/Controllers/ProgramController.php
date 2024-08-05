<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data pengguna yang sedang login
        $user = $request->user();
        // Memeriksa peran pengguna
        if ($user->role == 'admin' || $user->role == 'super_admin') {
            // Jika pengguna adalah admin atau super admin, ambil data program dan tampilkan halaman
            $programs = Program::with('user')->paginate(5);
            return view('pages.program.program_index', compact('programs'));
        } else {
            // Jika pengguna tidak memiliki akses, arahkan ulang atau tampilkan pesan kesalahan
            abort(401);
        }
    }

    public function create()
    {
        return view('pages.program.program_create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status' => 'required|string',
        ]);

        // Simpan data program baru
        Program::create([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        // Redirect ke halaman program dengan pesan sukses
        return redirect()->route('program.index')->with('success', 'Program berhasil dibuat.');
    }
}
