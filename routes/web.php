<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'initialPage']);

Route::get('/dashboard', [DashboardController::class, 'render'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/create', [TaskController::class, 'renderCreatePage'])->name('task.create');

Route::post('/create', [TaskController::class, 'create'])->name('task.create');

Route::put('/edit/{taskid}', [TaskController::class, 'edit'])->name('task.edit');

Route::delete('/task/delete', [TaskController::class, 'delete'])->name('task.delete');

Route::put('/task/check/{taskid}', [TaskController::class, 'check'])->name('task.check');

require __DIR__.'/auth.php';
