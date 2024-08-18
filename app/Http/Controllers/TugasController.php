<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Master;
use App\Models\Program;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search'); // Ambil input pencarian

        if ($user->role === 'user') {
            $activeMasterPrograms = Master::where('user_id', $user->id)
                ->where('status', 'Active')
                ->pluck('program_id')
                ->unique();

            $query = Program::withCount('tugas') // menghitung jumlah maateri
                ->whereIn('id', $activeMasterPrograms)
                ->where('status', 'Active');

            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }

            $programs = $query->latest()->get();
        } elseif ($user->role === 'admin') {
            $query = Program::withCount('tugas')
                ->where('user_id', $user->id);

            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }

            $programs = $query->latest()->get();
        } else {
            $query = Program::with('user')
                ->withCount('tugas')
                ->latest();

            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }

            $programs = $query->get();
            foreach ($programs as $program) {
                $program->created_at = Carbon::parse($program->created_at)->timezone('Asia/Jakarta');
                $program->updated_at = Carbon::parse($program->updated_at)->timezone('Asia/Jakarta');
            }
        }

        return view('pages.tugas.tugas_index', compact('programs', 'search'));
    }

    public function showByProgram(Program $program)
    {
        $tugass = Tugas::with('user')
            ->where('program_id', $program->id)
            ->paginate(5);
        return view('pages.tugas.show_by_program', compact('program', 'tugass'));
    }
    public function showDetailTugas(Program $program, Tugas $tugas)
    // program ini untuk menyimpan id program agar bisa kembali ke showByProgram
    {
        $tugas->created_at = Carbon::parse($tugas->created_at)->timezone('Asia/Jakarta');
        $tugas->updated_at = Carbon::parse($tugas->updated_at)->timezone('Asia/Jakarta');
        return view('pages.tugas.show_detail_tugas', compact('program', 'tugas'));
    }

    public function create(Program $program)
    {
        return view('pages.tugas.tugas_create', compact('program'));
    }

    public function edit(Tugas $tugas)
    {
        return view('pages.tugas.tugas_edit', compact('tugas'));
    }
}
