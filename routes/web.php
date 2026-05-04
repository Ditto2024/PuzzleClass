<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/daily-reward', [DashboardController::class, 'claimDailyReward'])->name('daily-reward.claim');

    Route::get('/quests', [QuestController::class, 'index'])->name('quests.index');
    Route::get('/quests/{quest}', [QuestController::class, 'show'])->name('quests.show');
    Route::get('/quests/{quest}/complete', [QuestController::class, 'complete'])->name('quests.complete');

    Route::post('/puzzle/{puzzle}/answer', [QuestController::class, 'answer'])->name('puzzle.answer');
    Route::post('/puzzle/{puzzle}/timeout', [QuestController::class, 'timeout'])->name('puzzle.timeout');
    Route::post('/puzzle/{puzzle}/hint', [QuestController::class, 'useHint'])->name('puzzle.hint');
    Route::post('/puzzle/{puzzle}/use-time', [QuestController::class, 'useTimeBoost'])->name('puzzle.use-time');

    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::post('/shop/{item}/buy', [ShopController::class, 'buy'])->name('shop.buy');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::patch('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/profile-page', [ProfileController::class, 'showGameProfile'])->name('profile.page');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';