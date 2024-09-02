<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tugas;
use App\Models\Program;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumpulanController extends Controller
{

    public function index(Program $program, Tugas $tugas)
    {
        $pengumpulans = Pengumpulan::where('tugas_id', $tugas->id)
            ->with('user')
            ->paginate(5);

        return view('pages.pengumpulan.pengumpulan_index', compact('pengumpulans', 'tugas', 'program'));
    }

    public function create(Program $program, Tugas $tugas)
    {
        // Misalkan ada relasi antara User dan Program melalui tabel Master
        $users = User::where('role', 'User')
            ->whereHas('master', function ($query) use ($program) {
                $query->where('program_id', $program->id);
            })
            ->get();

        return view('pages.pengumpulan.pengumpulan_create', compact('program', 'tugas', 'users'));
    }


    public function store(Request $request)
    {
        $rules = [
            'program_id' => 'required|exists:program,id',
            'tugas_id' => 'required|exists:tugas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:20971520',
        ];

        if (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        $file = $request->file('file');
        $filePath = $file->store('materis/Pengumpulan'); // Path tempat file disimpan
        $originalFileName = $file->getClientOriginalName(); // Nama file asli

        Pengumpulan::create([
            'user_id' => Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin' ? $request->user_id : Auth::user()->id,
            'program_id' => $request->program_id,
            'tugas_id' => $request->tugas_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file' => $originalFileName, // Simpan nama file asli
            'file_path' => $filePath, // Simpan path file
            'status' => 'Sudah Melakukan Pengajuan',
        ]);


        return redirect()->route('tugas.showDetailTugas', [$request->program_id, $request->tugas_id])
            ->with('success', 'Pengumpulan berhasil disimpan.');
    }

    public function destroy(Program $program, Tugas $tugas, Pengumpulan $pengumpulan)
    {
        // Hapus file yang terkait jika ada
        if ($pengumpulan->file && Storage::exists($pengumpulan->file)) {
            Storage::delete($pengumpulan->file);
        }

        // Hapus data pengumpulan dari database
        $pengumpulan->delete();

        return redirect()->route('pengumpulan.index', [$program->id, $tugas->id])
            ->with('success', 'Pengumpulan berhasil dihapus.');
    }

    public function destroyForUser(Program $program, Tugas $tugas, Pengumpulan $pengumpulan)
    {
        // Hapus file pengumpulan dari storage jika ada
        if ($pengumpulan->file && Storage::exists($pengumpulan->file)) {
            Storage::delete($pengumpulan->file);
        }

        // Hapus pengumpulan dari database
        $pengumpulan->delete();

        // Redirect kembali ke halaman detail tugas dengan pesan sukses
        return redirect()->route('tugas.showDetailTugas', [$program->id, $tugas->id])
            ->with('success', 'Pengumpulan berhasil dihapus.');
    }

    public function download(Pengumpulan $pengumpulan)
    {
        // Path lengkap ke file
        $filePath = storage_path('app/' . $pengumpulan->file_path);

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        // Dapatkan ekstensi file dari path
        // $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        // Mengembalikan respons unduhan
        return response()->download($filePath, $pengumpulan->file);
    }

    public function edit(Pengumpulan $pengumpulan)
    {
        return view('pages.pengumpulan.pengumpulan_edit', compact('pengumpulan'));
    }

    public function update(Request $request, Pengumpulan $pengumpulan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:20971520', // File opsional
            'program_id' => 'required|exists:program,id',
            'tugas_id' => 'required|exists:tugas,id',
        ]);

        // Update data materi
        $pengumpulan->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'program_id' => $request->program_id,
            'tugas_id' => $request->tugas_id,
        ]);

        // Update file jika ada
        if ($request->hasFile('file')) {
            // Hapus file lama dari storage
            Storage::delete($pengumpulan->file_path);

            // Simpan file baru
            $file = $request->file('file');
            $filePath = $file->store('materis/pengumpulan');
            $originalFileName = $file->getClientOriginalName();

            // Update path file di database
            $pengumpulan->update([
                'file_path' => $filePath,
                'file' => $originalFileName,
            ]);
        }

        if (Auth::user()->role === 'admin' || Auth::user()->role === "super_admin") {
            return redirect()->route('pengumpulan.index', [$request->program_id, $request->tugas_id])->with('success', 'Pengumpulan berhasil diperbarui.');
        } else {
            return redirect()->route('tugas.showDetailTugas', [$request->program_id, $request->tugas_id])->with('success', 'Pengumpulan berhasil diperbarui.');
        }
    }
}
