<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/welcome', function () {
//     return view('welcome');
// })->middleware(['auth', 'verified'])->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute untuk User
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user', function () {
        return view('user.index');
    })->middleware(['verified'])->name('user.index');
});

// rute untuk admin dan super admin
Route::middleware(['auth', 'verified'])->group(function () {
    // Program
    Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
    Route::get('/program/create', [ProgramController::class, 'create'])->name('program.create');
    Route::post('/program', [ProgramController::class, 'store'])->name('program.store');
    Route::get('/program/{program}/edit', [ProgramController::class, 'edit'])->name('program.edit');
    Route::put('/program/{program}', [ProgramController::class, 'update'])->name('program.update');
    Route::delete('/program/{program}', [ProgramController::class, 'destroy'])->name('program.destroy');
    Route::get('/program/search', [ProgramController::class, 'search'])->name('program.search');

    // Master
    Route::get('/master', [MasterController::class, 'index'])->name('master.index');
    Route::get('/master/create', [MasterController::class, 'create'])->name('master.create');
    Route::post('/master', [MasterController::class, 'store'])->name('master.store');
    Route::delete('master/{master}', [MasterController::class, 'destroy'])->name('master.destroy');
    Route::get('/master/{master}/edit', [MasterController::class, 'edit'])->name('master.edit');
    Route::put('/master/{master}', [MasterController::class, 'update'])->name('master.update');
    Route::get('/master/search', [MasterController::class, 'search'])->name('master.search');

    // Materi
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/program/{program}', [MateriController::class, 'showByProgram'])->name('materi.showByProgram');
    Route::get('/materi/create/{program}', [MateriController::class, 'create'])->name('materi.create');
    Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');
    Route::get('/materi/download/{materi}', [MateriController::class, 'download'])->name('materi.download');
    Route::get('materi/edit/{materi}', [MateriController::class, 'edit'])->name('materi.edit');
    Route::put('materi/{materi}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{materi}', [MateriController::class, 'destroy'])->name('materi.destroy');

    // Tugas
    Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
    Route::get('/tugas/program/{program}', [TugasController::class, 'showByProgram'])->name('tugas.showByProgram');
    Route::get('/tugas/{program}/{tugas}', [TugasController::class, 'showDetailTugas'])->name('tugas.showDetailTugas');
});

// Rute untuk Admin
// Route::middleware(['auth', 'admin', 'verified'])->group(function () {
//     Route::get('/admin/program', [ProgramController::class, 'index'])->name('admin.program');
// });

// Rute untuk Super Admin
// Route::middleware(['auth', 'super_admin', 'verified'])->group(function () {
//     Route::get('/super_admin/program', [ProgramController::class, 'index'])->name('super_admin.program');
// });


require __DIR__ . '/auth.php';
