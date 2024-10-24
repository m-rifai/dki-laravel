<?php

use App\Http\Controllers\AccountApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth', 'role:CS'])->group(function () {
        Route::get('/applications', [AccountApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/create', [AccountApplicationController::class, 'create'])->name('applications.create');
        Route::post('/applications', [AccountApplicationController::class, 'store'])->name('applications.store');
    });

    Route::middleware(['auth', 'role:Supervisor'])->group(function () {
        Route::get('/applications/all', [AccountApplicationController::class, 'indexAll'])->name('applications.indexAll');
        Route::post('/applications/{id}/approve', [AccountApplicationController::class, 'approve'])->name('applications.approve');

        Route::resource('users', UserController::class);
        // Route::get('/users', [UserController::class, 'index'])->name('users.index');
        // Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        // Route::post('/users', [UserController::class, 'store'])->name('users.store');
        // Route::patch('/users', [UserController::class, 'update'])->name('users.update');
        Route::get('/users/blocked', [UserController::class, 'blockedUsers'])->name('users.blocked');
        Route::post('/users/{id}/unblock', [UserController::class, 'unblockUser'])->name('users.unblock');
    });
});

require __DIR__ . '/auth.php';
