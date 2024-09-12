<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tugas;
use App\Models\Master;
use App\Models\Pengumpulan;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
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

            $query = Program::withCount(['tugas' => function ($query) use ($user) {
                // Menghitung tugas yang belum dikumpulkan
                $query->whereDoesntHave('pengumpulan', function ($subQuery) use ($user) {
                    $subQuery->where('user_id', $user->id);
                });
            }])
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
        $userId = Auth::id(); // Mengambil ID user yang sedang login

        $tugass = Tugas::with('user')
            ->leftJoin('pengumpulan', function ($join) use ($userId) {
                $join->on('tugas.id', '=', 'pengumpulan.tugas_id')
                    ->where('pengumpulan.user_id', '=', $userId);
            })
            ->where('tugas.program_id', $program->id)
            ->select('tugas.*', 'pengumpulan.status')
            ->paginate(5);

        foreach ($tugass as $tugas) {
            $tugas->deadline = $tugas->deadline ? Carbon::parse($tugas->deadline)->translatedFormat('l, d-m-Y H:i') : 'Tidak ada deadline';
            $tugas->status = $tugas->status ?? 'Belum ada pengajuan yang dibuat'; // Jika status null, berarti belum mengumpulkan
        }

        return view('pages.tugas.show_by_program', compact('program', 'tugass'));
    }

    public function showDetailTugas(Program $program, Tugas $tugas)
    {
        $user = Auth::user();
        $pengumpulan = Pengumpulan::where('user_id', $user->id)
            ->where('tugas_id', $tugas->id)
            ->first();

        $tugas->deadline = $tugas->deadline ? Carbon::parse($tugas->deadline)->translatedFormat('l, d-m-Y H:i') : 'Tidak Ada';
        $tugas->created_at = Carbon::parse($tugas->created_at)->timezone('Asia/Jakarta');
        $tugas->updated_at = Carbon::parse($tugas->updated_at)->timezone('Asia/Jakarta');

        // Menghitung waktu tersisa
        $now = Carbon::now('Asia/Jakarta');
        $deadline = Carbon::parse($tugas->deadline);

        // Memeriksa apakah deadline telah lewat dan memformat waktu tersisa
        $timeLeft = $deadline->diff($now);
        $remainingTime = $now->greaterThan($deadline) ? 'Waktu telah habis' : $timeLeft->format('%a hari %h jam %i menit %s detik');

        return view('pages.tugas.show_detail_tugas', compact('program', 'tugas', 'pengumpulan', 'remainingTime'));
    }


    public function create(Program $program)
    {
        return view('pages.tugas.tugas_create', compact('program'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:program,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:20971520',
            'deadline' => 'nullable|date',
        ]);

        // $file = $request->file('file');
        // $filePath = $file->store('materis/Tugas');
        // kodingan lebih singkat
        $filePath = $request->file->store('materis/Tugas');

        Tugas::create([
            'user_id' => Auth::id(),
            'program_id' => $request->program_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('tugas.showByProgram', $request->program_id)->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function download(Tugas $tugas)
    {
        // Path lengkap ke file
        $filePath = storage_path('app/' . $tugas->file);

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        // Dapatkan ekstensi file dari path
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        // Mengembalikan respons unduhan
        return response()->download($filePath, $tugas->judul . '.' . $fileExtension);
    }

    public function edit(Tugas $tugas)
    {
        return view('pages.tugas.tugas_edit', compact('tugas'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:20971520', // File opsional
            'deadline' => 'nullable|date_format:Y-m-d\TH:i',
            'program_id' => 'required|exists:program,id',
        ]);

        // Update data materi
        $tugas->update([
            'user_id' => Auth::user()->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->input('deadline') ? Carbon::parse($request->input('deadline')) : null,
            'program_id' => $request->program_id,

        ]);

        // Update file jika ada
        if ($request->hasFile('file')) {
            // Hapus file lama dari storage
            Storage::delete($tugas->file);

            // Simpan file baru
            $file = $request->file('file');
            $filePath = $file->store('materis/tugas');

            // Update path file di database
            $tugas->update(['file' => $filePath]);
        }

        return redirect()->route('tugas.showByProgram', $request->program_id)->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tugas)
    {
        // Hapus file pengumpulan yang terkait dengan tugas id
        $pengumpulans = $tugas->pengumpulan;

        foreach ($pengumpulans as $pengumpulan) {
            if ($pengumpulan->file) {
                Storage::delete($pengumpulan->file);
            }
            $pengumpulan->delete();
        }

        // Hapus file tugas dari storage
        if ($tugas->file) {
            Storage::delete($tugas->file);
        }

        // Hapus tugas dari database
        $tugas->delete();

        // Redirect ke halaman program dengan pesan sukses
        return redirect()->route('tugas.showByProgram', $tugas->program_id)
            ->with('success', 'Tugas dan semua pengumpulan terkait berhasil dihapus.');
    }
}
