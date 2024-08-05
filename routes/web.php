<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
    Route::get('/program/create', [ProgramController::class, 'create'])->name('program.create');
    Route::post('/program', [ProgramController::class, 'store'])->name('program.store');
});

// Rute untuk Admin
// Route::middleware(['auth', 'admin', 'verified'])->group(function () {
//     Route::get('/admin/program', [ProgramController::class, 'index'])->name('admin.program');
// });

// Rute untuk Super Admin
// Route::middleware(['auth', 'super_admin', 'verified'])->group(function () {
//     Route::get('/super_admin/program', [ProgramController::class, 'index'])->name('super_admin.program');
// });


require __DIR__.'/auth.php';
