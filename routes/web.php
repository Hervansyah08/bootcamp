<?php

use App\Http\Controllers\ProfileController;
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

Route::middleware('auth','user')->group(function () {
    Route::get('/user', function () {
        return view('user.index');
    })->name('user.index');
});
Route::middleware('auth','admin')->group(function () {
    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.index');
});
Route::middleware('auth','super_admin')->group(function () {
    Route::get('/super-admin', function () {
        return view('super_admin.index');
    })->name('super_admin.index');
});

require __DIR__.'/auth.php';
