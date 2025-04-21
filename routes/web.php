<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [TaskController::class, "index"])->name('dashboard');
    Route::post('/task', [TaskController::class, "store"])->name('task.store');
    Route::delete('/task/{id}', [TaskController::class, "destroy"])->name('task.destroy');
    Route::put('/task/{id}', [TaskController::class, "update"])->name('task.update');
    Route::put('/task-marking/{id}', [TaskController::class, "marking"])->name('task.marking');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
