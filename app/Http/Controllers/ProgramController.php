<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data pengguna yang sedang login
        $user = $request->user();
        // Memeriksa peran pengguna
        if ($user->role == 'admin' || $user->role == 'super_admin') {
            // Jika pengguna adalah admin atau super admin, ambil data program dan tampilkan halaman
            // Mengurutkan berdasarkan yang terbaru
            $programs = Program::with('user')->latest()->paginate(5);
            foreach ($programs as $program) {
                $program->created_at = Carbon::parse($program->created_at)->timezone('Asia/Jakarta');
            }
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
            'deskripsi' => 'nullable|string',
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

    // Method untuk menampilkan form edit
    public function edit(Program $program) //menggunakan route model binding
    {
        return view('pages.program.program_edit', compact('program'));
    }

    // Method untuk mengupdate data program
    public function update(Request $request, Program $program)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string',
        ]);

        // Update data program
        $program->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        // Redirect ke halaman program dengan pesan sukses
        return redirect()->route('program.index')->with('success', 'Program berhasil diperbarui.');
    }

    // Method untuk menghapus data program
    public function destroy(Program $program) //menggunakan route model binding
    {
        $program->delete();

        return redirect()->route('program.index')->with('success', 'Program berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');

        // Cek apakah keyword kosong
        if (empty($keyword)) {
            // Jika kosong, ambil semua data
            $programs = Program::with('user')->latest()->paginate(5);
        } else {
            // Jika tidak kosong, lakukan pencarian
            $programs = Program::where('nama', 'like', "%" . $keyword . "%")
                ->orWhere('deskripsi', 'like', "%" . $keyword . "%")
                ->with('user')
                ->paginate(5)
                ->withQueryString();
        }

        return view('pages.program.program_index', compact('programs'));
    }
}
