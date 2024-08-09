<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Master;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data pengguna yang sedang login
        $user = $request->user();
        // Memeriksa peran pengguna
        if ($user->role == 'admin' || $user->role == 'super_admin') {
            // Jika pengguna adalah admin atau super admin, ambil data program dan tampilkan halaman
            // Mengurutkan berdasarkan yang terbaru
            $masters = Master::with('user', 'program')->latest()->paginate(5);
            foreach ($masters as $master) {
                $master->created_at = Carbon::parse($master->created_at)->timezone('Asia/Jakarta');
            }
            return view('pages.master.master_index', compact('masters'));
        } else {
            // Jika pengguna tidak memiliki akses, arahkan ulang atau tampilkan pesan kesalahan
            abort(401);
        }
    }

    public function create()
    {
        $programs = Program::all();
        return view('pages.master.master_create', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'nama' => 'required|string|max:255',
            'gender' => 'required|in:Pria,Wanita',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'status_pekerjaan' => 'required|string',
            'instansi' => 'required|string',
            'program_id' => 'required|exists:program,id',
            'info' => 'required|string',
            'motivasi' => 'nullable|string',
        ]);

        Master::create([
            'user_id' => Auth::user()->id,
            'email' => $request->email,
            'nama' => $request->nama,
            'gender' => $request->gender,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'status_pekerjaan' => $request->status_pekerjaan,
            'instansi' => $request->instansi,
            'program_id' => $request->program_id,
            'info' => $request->info,
            'motivasi' => $request->motivasi,
        ]);

        if (Auth::user()->role === 'admin' || Auth::user()->role === "super_admin") {
            return redirect()->route('master.index')->with('success', 'Master created successfully.');
        } else {
            $programs = Program::all();
            return view('pages.master.master_create', compact('programs'));
        }
    }
}
