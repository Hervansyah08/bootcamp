<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Master;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search'); // Ambil input pencarian

        if ($user->role === 'user') {
            $activeMasterPrograms = Master::where('user_id', $user->id)
                ->where('status', 'Active')
                ->whereIn('tipe_kelas', ['Lengkap', 'Dokumen'])
                ->pluck('program_id')
                ->unique();

            $query = Program:: // menghitung jumlah tugas
                whereIn('id', $activeMasterPrograms)
                ->where('status', 'Active');

            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }

            $programs = $query->latest()->get();
        } elseif ($user->role === 'admin') {
            $query = Program::where('user_id', $user->id);

            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }

            $programs = $query->latest()->get();
        } else {
            $query = Program::with('user')
                ->latest();

            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }

            $programs = $query->get();
            // foreach ($programs as $program) {
            //     $program->created_at = Carbon::parse($program->created_at)->timezone('Asia/Jakarta');
            //     $program->updated_at = Carbon::parse($program->updated_at)->timezone('Asia/Jakarta');
            // }
        }

        return view('pages.kelas.kelas_index', compact('programs', 'search'));
    }

    public function showByProgram(Program $program)
    {
        $kelass = Kelas::with('user')
            ->where('program_id', $program->id)
            ->paginate(5);

        return view('pages.kelas.show_by_program', compact('program', 'kelass'));
    }

    public function create(Program $program)
    {
        return view('pages.kelas.kelas_create', compact('program'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:program,id',
            'judul' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'link' => 'required|string',
        ]);

        Kelas::create([
            'user_id' => Auth::id(),
            'program_id' => $request->program_id,
            'judul' => $request->judul,
            'detail' => $request->detail,
            'link' => $request->link,
        ]);

        return redirect()->route('kelas.showByProgram', $request->program_id)->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        return view('pages.kelas.kelas_edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        // Validasi input
        $request->validate([
            'program_id' => 'required|exists:program,id',
            'judul' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'link' => 'required|string',
        ]);

        // Update data program
        $kelas->update([
            'user_id' => Auth::id(),
            'program_id' => $request->program_id,
            'judul' => $request->judul,
            'detail' => $request->detail,
            'link' => $request->link,
        ]);

        return redirect()->route('kelas.showByProgram', $request->program_id)->with('success', 'Kelas berhasil diedit ditambahkan.');
    }
    public function destroy(Kelas $kelas) //menggunakan route model binding
    {

        $kelas->delete();

        return redirect()->route('kelas.showByProgram', $kelas->program_id)->with('success', 'Jadwal Kelas berhasil dihapus.');
    }
}
