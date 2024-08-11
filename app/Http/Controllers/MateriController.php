<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Master;
use App\Models\Materi;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'user') {
            $activeMasterPrograms = Master::where('user_id', $user->id)
                ->where('status', 'Active')
                ->pluck('program_id')
                ->unique();

            $programs = Program::withCount('materi') // // Tujuan: withCount memungkinkan Anda menghitung jumlah record yang terkait dengan model melalui relasi. jadi 1 program punya berapa materi
                ->whereIn('id', $activeMasterPrograms)
                ->where('status', 'Active')
                ->latest()
                ->get();
        } else {
            $programs = Program::with('user')
                ->withCount('materi') // Tujuan: withCount memungkinkan Anda menghitung jumlah record yang terkait dengan model melalui relasi. jadi 1 program punya berapa materi
                ->latest()
                ->get();
            foreach ($programs as $program) {
                $program->created_at = Carbon::parse($program->created_at)->timezone('Asia/Jakarta');
                $program->updated_at = Carbon::parse($program->updated_at)->timezone('Asia/Jakarta');
            }
        }

        return view('pages.materi.materi_index', compact('programs'));
    }

    // $programs = Program::with('materi')->get();
    public function showByProgram(Program $program)
    {
        $materis = Materi::with('user')
            ->where('program_id', $program->id)
            ->get();
        foreach ($materis as $materi) {
            $materi->created_at = Carbon::parse($materi->created_at)->timezone('Asia/Jakarta');
            $materi->updated_at = Carbon::parse($materi->updated_at)->timezone('Asia/Jakarta');
        }
        return view('pages.materi.show_by_program', compact('program', 'materis'));
    }

    public function create(Program $program)
    {
        // $programs = Program::all();
        return view('pages.materi.materi_create', compact('program'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:program,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:20971520',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('materis');

        Materi::create([
            'user_id' => Auth::id(),
            'program_id' => $request->program_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath,
        ]);

        return redirect()->route('materi.showByProgram', $request->program_id)->with('success', 'Materi berhasil ditambahkan.');
    }
}
