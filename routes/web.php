<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\RoleAdminController;
use App\Http\Controllers\PengumpulanController;

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
// Route::middleware(['auth', 'user'])->group(function () {
//     Route::get('/user', function () {
//         return view('user.index');
//     })->middleware(['verified'])->name('user.index');
// });

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
    Route::get('materi/video/{filename}', [MateriController::class, 'streamVideo'])->name('materi.streamVideo');
    Route::get('materi/edit/{materi}', [MateriController::class, 'edit'])->name('materi.edit');
    Route::put('materi/{materi}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{materi}', [MateriController::class, 'destroy'])->name('materi.destroy');



    // Tugas
    // definisikan route spesifik terlebih dahulu agar tidak error 404
    Route::get('/tugas/create/{program}', [TugasController::class, 'create'])->name('tugas.create');
    Route::get('/tugas/edit/{tugas}', [TugasController::class, 'edit'])->name('tugas.edit');
    Route::get('/tugas/download/{tugas}', [TugasController::class, 'download'])->name('tugas.download');
    Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
    Route::get('/tugas/program/{program}', [TugasController::class, 'showByProgram'])->name('tugas.showByProgram');
    Route::get('/tugas/{program}/{tugas}', [TugasController::class, 'showDetailTugas'])->name('tugas.showDetailTugas');
    Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
    Route::put('tugas/{tugas}', [TugasController::class, 'update'])->name('tugas.update');
    Route::delete('/tugas/{tugas}', [TugasController::class, 'destroy'])->name('tugas.destroy');

    // Pengumpulan
    Route::get('program/{program}/tugas/{tugas}/pengumpulan', [PengumpulanController::class, 'index'])
        ->name('pengumpulan.index');
    Route::get('program/{program}/tugas/{tugas}/pengumpulan/create', [PengumpulanController::class, 'create'])->name('pengumpulan.create');
    Route::post('/pengumpulan/store', [PengumpulanController::class, 'store'])->name('pengumpulan.store');
    Route::delete('program/{program}/tugas/{tugas}/pengumpulan/{pengumpulan}', [PengumpulanController::class, 'destroy'])
        ->name('pengumpulan.destroy');
    Route::delete('program/{program}/tugas/{tugas}/pengumpulan/{pengumpulan}/user', [PengumpulanController::class, 'destroyForUser'])
        ->name('pengumpulan.destroyForUser');
    Route::get('/pengumpulan/download/{pengumpulan}', [PengumpulanController::class, 'download'])->name('pengumpulan.download');
    Route::get('/pengumpulan/edit/{pengumpulan}', [PengumpulanController::class, 'edit'])->name('pengumpulan.edit');
    Route::put('pengumpulan/{pengumpulan}', [PengumpulanController::class, 'update'])->name('pengumpulan.update');

    // Kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/program/{program}', [KelasController::class, 'showByProgram'])->name('kelas.showByProgram');
    Route::get('/kelas/create/{program}', [KelasController::class, 'create'])->name('kelas.create');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/edit/{kelas}', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('kelas/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('kelas/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    // Quiz
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/quiz/program/{program}', [QuizController::class, 'showByProgram'])->name('quiz.showByProgram');
    Route::get('/quiz/create/{program}', [QuizController::class, 'create'])->name('quiz.create');
    Route::post('quiz', [QuizController::class, 'store'])->name('quiz.store');
    Route::get('/quiz/edit/{quiz}', [QuizController::class, 'edit'])->name('quiz.edit');
    Route::put('quiz/{quiz}', [QuizController::class, 'update'])->name('quiz.update');
    Route::delete('quiz/{quiz}', [QuizController::class, 'destroy'])->name('quiz.destroy');

    // role
    // user
    Route::get('/user', [RoleUserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [RoleUserController::class, 'create'])->name('user.create');
    Route::post('/user', [RoleUserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{user}', [RoleUserController::class, 'edit'])->name('user.edit');
    Route::put('user/{user}', [RoleUserController::class, 'update'])->name('user.update');
    Route::delete('user/{user}', [RoleUserController::class, 'destroy'])->name('user.destroy');
    Route::get('/user/search', [RoleUserController::class, 'search'])->name('user.search');

    // admin
    Route::get('/admin', [RoleAdminController::class, 'index'])->name('admin.index');
});

require __DIR__ . '/auth.php';
