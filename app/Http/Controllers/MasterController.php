<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
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
        $programs = Program::where('status', 'Active')->get();
        // Menyaring berdasarkan nilai kolom tertentu. Ini adalah pencarian yang lebih spesifik, karena hanya mempertimbangkan nilai yang tepat dari kolom status.
        $users = User::all(); // Ambil semua pengguna

        return view('pages.master.master_create', compact('programs', 'users'));
    }

    public function store(Request $request)
    {
        $rules = [
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
        ];

        if (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        Master::create([
            'user_id' => Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin' ? $request->user_id : Auth::user()->id,
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
            $programs = Program::where('status', 'Active')->get();
            //Menyaring berdasarkan nilai kolom tertentu. Ini adalah pencarian yang lebih spesifik, karena hanya mempertimbangkan nilai yang tepat dari kolom status.
            return view('pages.master.master_create', compact('programs'));
        }
    }

    public function destroy(Master $master)
    {
        $master->delete();

        return redirect()->route('master.index');
    }

    public function edit(Master $master)
    {
        $programs = Program::where('status', 'Active')->get();
        return view('pages.master.master_edit', compact('master', 'programs'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Master $master)
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
            'status' => 'nullable|string',
        ]);

        $master->update($request->all());

        return redirect()->route('master.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');

        // Cek apakah keyword kosong
        if (empty($keyword)) {
            // Jika kosong, ambil semua data
            $masters = Master::with('user', 'program')->latest()->paginate(5);
        } else {
            // Jika tidak kosong, lakukan pencarian
            $masters = Master::where('nama', 'like', "%" . $keyword . "%") //Menyaring berdasarkan pola teks dalam kolom tertentu. Ini adalah pencarian yang lebih fleksibel, karena dapat menemukan data yang memiliki substring tertentu di kolom nama.
                ->orWhere('email', 'like', "%" . $keyword . "%")
                ->with('user', 'program')
                ->paginate(5)
                ->withQueryString();
        }

        return view('pages.master.master_index', compact('masters'));
    }
}
