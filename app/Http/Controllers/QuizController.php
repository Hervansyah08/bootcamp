<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Master;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
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

        return view('pages.quiz.quiz_index', compact('programs', 'search'));
    }

    public function showByProgram(Program $program)
    {
        $quizs = Quiz::with('user')
            ->where('program_id', $program->id)
            ->paginate(5);

        return view('pages.quiz.show_by_program', compact('program', 'quizs'));
    }

    public function create(Program $program)
    {
        return view('pages.quiz.quiz_create', compact('program'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:program,id',
            'judul' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'link' => 'required|string',
        ]);

        Quiz::create([
            'user_id' => Auth::id(),
            'program_id' => $request->program_id,
            'judul' => $request->judul,
            'detail' => $request->detail,
            'link' => $request->link,
        ]);

        return redirect()->route('quiz.showByProgram', $request->program_id)->with('success', 'Quiz berhasil ditambahkan.');
    }

    public function destroy(Quiz $quiz) //menggunakan route model binding
    {

        $quiz->delete();

        return redirect()->route('quiz.showByProgram', $quiz->program_id)->with('success', 'Quiz berhasil dihapus.');
    }
}
