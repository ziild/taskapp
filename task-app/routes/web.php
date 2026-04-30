<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect the homepage to the dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {
    
    // THE IMPORTANT ONE: Named 'dashboard' so Login/Register work
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');
    
    // Task Actions
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Profile Actions
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// This loads the Breeze auth routes (Login, Register, Logout logic)
require __DIR__.'/auth.php';