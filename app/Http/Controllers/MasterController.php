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
            if ($user->role == 'admin') {
                // Jika pengguna adalah admin, ambil data program yang dibuat oleh admin tersebut
                $programIds = Program::where('user_id', $user->id)->pluck('id');
                $masters = Master::whereIn('program_id', $programIds)
                    ->with('user', 'program')
                    ->latest()
                    ->paginate(5);
            } else {
                // Jika pengguna adalah super admin, ambil semua data Master
                $masters = Master::with('user', 'program')
                    ->latest()
                    ->paginate(5);
            }

            // Mengubah timezone pada timestamp
            foreach ($masters as $master) {
                $master->created_at = Carbon::parse($master->created_at)->timezone('Asia/Jakarta');
                $master->updated_at = Carbon::parse($master->updated_at)->timezone('Asia/Jakarta');
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
        // $users = User::all(); // Ambil semua pengguna
        $users = User::where('role', 'User')->get();

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
            $masters = Master::join('program', 'master.program_id', '=', 'program.id') //join menggabungkan tabel
                ->where(function ($query) use ($keyword) {
                    $query->where('master.nama', 'like', "%" . $keyword . "%")
                        ->orWhere('program.nama', 'like', "%" . $keyword . "%");
                })
                ->with('user', 'program')
                ->select('master.*') // Pastikan hanya kolom dari master yang diambil
                ->paginate(5)
                ->withQueryString();
        }

        return view('pages.master.master_index', compact('masters'));
    }
}
