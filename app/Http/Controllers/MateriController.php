<?php

namespace App\Http\Controllers;

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
            // Ambil ID program yang terkait dengan pengguna yang statusnya 'Active'
            $activeMasterPrograms = Master::where('user_id', $user->id)
                ->where('status', 'Active')
                ->pluck('program_id')
                ->unique(); // Ambil ID program yang unik

            // Ambil program dengan ID yang didapat dan status 'Active'
            $programs = Program::whereIn('id', $activeMasterPrograms)
                ->where('status', 'Active')
                ->get();
        } else {
            // Jika peran pengguna bukan 'user', ambil semua program
            $programs = Program::all();
        }

        return view('pages.materi.materi_index', compact('programs'));
    }


    // $programs = Program::with('materi')->get();
    public function showByProgram(Program $program)
    {
        $materis = Materi::where('program_id', $program->id)->get();
        return view('pages.materi.show_by_program', compact('program', 'materis'));
    }

    public function create()
    {
        $programs = Program::all();
        return view('pages.materi.materi_create', compact('programs'));
    }
}
