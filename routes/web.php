<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // QUEST
    Route::get('/quests', [QuestController::class, 'index'])->name('quests.index');
    Route::get('/quests/{quest}', [QuestController::class, 'show'])->name('quests.show');

    // PUZZLE ANSWER
    Route::post('/puzzle/{puzzle}/answer', [QuestController::class, 'answer'])->name('puzzle.answer');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';