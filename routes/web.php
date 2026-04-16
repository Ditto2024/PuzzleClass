<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PuzzleController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/quests', [QuestController::class, 'index'])->name('quests.index');
    Route::get('/quests/{quest}', [QuestController::class, 'show'])->name('quests.show');
    Route::get('/puzzles/{puzzle}', [PuzzleController::class, 'show'])->name('puzzles.show');
    Route::post('/puzzles/{puzzle}/submit', [PuzzleController::class, 'submit'])->name('puzzles.submit');
    Route::post('/puzzles/{puzzle}/hint', [PuzzleController::class, 'hint'])->name('puzzles.hint');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::post('/shop/{shopItem}/buy', [ShopController::class, 'buy'])->name('shop.buy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
});

require __DIR__.'/auth.php';