<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data pengguna yang sedang login
        $user = $request->user();

        if ($user->role == 'admin' || $user->role == 'super_admin') {
            // Jika pengguna adalah admin atau super admin
            if ($user->role == 'admin') {
                // Jika pengguna adalah admin, hanya tampilkan program yang dibuat oleh admin tersebut
                $programs = Program::where('user_id', $user->id)
                    ->latest() // menampilkan data terbaru
                    ->paginate(5);
            } else {
                // Jika pengguna adalah super admin, tampilkan semua program
                $programs = Program::with('user')
                    ->latest()
                    ->paginate(5);
            }

            // Mengubah timezone pada timestamp
            foreach ($programs as $program) {
                $program->created_at = Carbon::parse($program->created_at)->timezone('Asia/Jakarta');
                $program->updated_at = Carbon::parse($program->updated_at)->timezone('Asia/Jakarta');
            }

            return view('pages.program.program_index', compact('programs'));
        } else {
            // Jika pengguna tidak memiliki akses, arahkan ulang atau tampilkan pesan kesalahan
            abort(401);
        }
    }


    public function create()
    {
        $users = User::where('role', 'admin')->get();
        return view('pages.program.program_create', compact('users'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $rules = [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string',
        ];

        if (Auth::user()->role === 'super_admin') {
            $rules['user_id'] = 'required|exists:users,id';
        }

        // Simpan data program baru
        Program::create([
            'user_id' => Auth::user()->role === 'super_admin' ? $request->user_id : Auth::user()->id,
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
