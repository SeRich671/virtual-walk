<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('project/published/{shareUrl}', [ProjectController::class, 'show'])->name('project.show');

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('project', ProjectController::class, [
        'except' => ['show']
    ]);

    Route::prefix('project/{project}')->name('project.')->group(function () {
        Route::get('publish', [ProjectController::class, 'publish'])->name('publish');
        Route::get('hide', [ProjectController::class, 'hide'])->name('hide');
        Route::resource('photo', PhotoController::class);
    });
});

require __DIR__.'/auth.php';
