<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Program;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumpulanController extends Controller
{

    public function index(Tugas $tugas)
    {
        $pengumpulans = Pengumpulan::where('tugas_id', $tugas->id)
            ->with('user')
            ->get();

        return view('pages.pengumpulan.pengumpulan_index', compact('pengumpulans', 'tugas'));
    }

    public function create(Program $program, Tugas $tugas)
    {
        return view('pages.pengumpulan.pengumpulan_create', compact('program', 'tugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:program,id',
            'tugas_id' => 'required|exists:tugas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:20971520',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('materis/Pengumpulan');

        Pengumpulan::create([
            'user_id' => Auth::id(),
            'program_id' => $request->program_id,
            'tugas_id' => $request->tugas_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath,
            'status' => 'Done',
        ]);

        return redirect()->route('tugas.showDetailTugas', [$request->program_id, $request->tugas_id])
            ->with('success', 'Pengumpulan berhasil disimpan.');
    }
}
