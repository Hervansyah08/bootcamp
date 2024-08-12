<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Master;
use App\Models\Materi;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        } elseif ($user->role === 'admin') {
            $programs = Program::withCount('materi')
                ->where('user_id', $user->id)
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

    public function download(Materi $materi)
    {
        // Path lengkap ke file
        $filePath = storage_path('app/' . $materi->file);

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        // Dapatkan ekstensi file dari path
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        // Mengembalikan respons unduhan
        return response()->download($filePath, $materi->judul . '.' . $fileExtension);
    }

    public function edit(Materi $materi)
    {
        // $programs = Program::where('status', 'Active')->get();
        return view('pages.materi.materi_edit', compact('materi'));
    }


    // Metode untuk menyimpan update
    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:209715208', // File opsional
            'program_id' => 'required|exists:program,id',
        ]);

        // Update data materi
        $materi->update([
            'user_id' => Auth::user()->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'program_id' => $request->program_id,
        ]);

        // Update file jika ada
        if ($request->hasFile('file')) {
            // Hapus file lama dari storage
            Storage::delete($materi->file);

            // Simpan file baru
            $file = $request->file('file');
            $filePath = $file->store('materis');

            // Update path file di database
            $materi->update(['file' => $filePath]);
        }

        return redirect()->route('materi.showByProgram', $request->program_id)->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        // Hapus file dari storage
        Storage::delete($materi->file);

        // Hapus materi dari database
        $materi->delete();

        // Redirect ke halaman program dengan pesan sukses
        return redirect()->route('materi.showByProgram', $materi->program_id)
            ->with('success', 'Materi berhasil dihapus.');
    }
}
