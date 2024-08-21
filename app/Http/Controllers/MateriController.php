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
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search'); // Ambil input pencarian

        if ($user->role === 'user') {
            $activeMasterPrograms = Master::where('user_id', $user->id)
                ->where('status', 'Active')
                ->pluck('program_id')
                ->unique();

            $query = Program::withCount('materi') // menghitung jumlah maateri
                ->whereIn('id', $activeMasterPrograms)
                ->where('status', 'Active');

            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }

            $programs = $query->latest()->get();
        } elseif ($user->role === 'admin') {
            $query = Program::withCount('materi')
                ->where('user_id', $user->id);

            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }

            $programs = $query->latest()->get();
        } else {
            $query = Program::with('user')
                ->withCount('materi')
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

        return view('pages.materi.materi_index', compact('programs', 'search'));
    }

    public function showByProgram(Program $program)
    {
        $user = Auth::user();

        if ($user->role == 'admin' || $user->role == 'super_admin') {
            // Ambil semua materi untuk admin dan super admin
            $materis = Materi::with('user')
                ->where('program_id', $program->id)
                ->get();

            // Tidak perlu inisialisasi tipe_kelas untuk admin dan super admin
            $tipeKelas = 'all';
        } else {
            // Ambil tipe kelas berdasarkan user_id dan program_id dari tabel master
            $master = Master::where('user_id', $user->id)
                ->where('program_id', $program->id)
                ->first();

            // Default tipe_kelas adalah 'lengkap'
            $tipeKelas = $master->tipe_kelas;

            // Ambil materi berdasarkan tipe kelas
            $materis = Materi::with('user')
                ->where('program_id', $program->id)
                ->when($tipeKelas == 'course', function ($query) {
                    return $query->whereNotNull('video')->whereNull('file');
                })
                ->when($tipeKelas == 'dokumen', function ($query) {
                    return $query->whereNotNull('file')->whereNull('video');
                })
                ->when($tipeKelas == 'lengkap', function ($query) {
                    return $query->whereNotNull('file')->orWhereNotNull('video');
                })
                ->get();
        }

        // Format timestamp sesuai timezone Asia/Jakarta
        foreach ($materis as $materi) {
            $materi->created_at = Carbon::parse($materi->created_at)->timezone('Asia/Jakarta');
            $materi->updated_at = Carbon::parse($materi->updated_at)->timezone('Asia/Jakarta');
        }

        // Return view dengan data program, materi, dan tipe_kelas
        return view('pages.materi.show_by_program', [
            'program' => $program,
            'materis' => $materis,
            'tipeKelas' => $tipeKelas
        ]);
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
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:20971520',
            'video' => 'nullable|file|mimes:mp4,mov,ogg,qt,avi,mkv|max:307200', // Validasi video file dengan ukuran maksimum 300MB
        ]);

        $file = $request->file('file');
        $filePath = $file->store('materis/files');

        $video = $request->file('video');
        $videoPath = $video->store('materis/videos'); // Simpan video di folder terpisah

        Materi::create([
            'user_id' => Auth::id(),
            'program_id' => $request->program_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath,
            'video' => $videoPath,
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

    public function streamVideo($filename)
    {
        $path = storage_path('app/materis/videos/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'Video not found.');
        }

        $mimeType = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
        ]);
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
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:20971520', // File opsional
            'video' => 'nullable|file|mimes:mp4,mov,ogg,qt,avi,mkv|max:307200', // Validasi video file dengan ukuran maksimum 300MB
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
            $filePath = $file->store('materis/files');

            // Update path file di database
            $materi->update(['file' => $filePath]);
        }
        if ($request->hasFile('video')) {
            // Hapus file lama dari storage
            Storage::delete($materi->video);

            // Simpan file baru
            $file = $request->file('video');
            $filePath = $file->store('materis/videos');

            // Update path file di database
            $materi->update(['video' => $filePath]);
        }

        return redirect()->route('materi.showByProgram', $request->program_id)->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        // Hapus file dari storage
        Storage::delete($materi->file);
        Storage::delete($materi->video);

        // Hapus materi dari database
        $materi->delete();

        // Redirect ke halaman program dengan pesan sukses
        return redirect()->route('materi.showByProgram', $materi->program_id)
            ->with('success', 'Materi berhasil dihapus.');
    }
}
