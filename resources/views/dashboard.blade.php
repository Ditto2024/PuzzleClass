<x-app-layout>
<div class="p-6">
    <h1 class="text-2xl font-bold">Dashboard</h1>

    <div class="grid grid-cols-4 gap-4 mt-4">
        <div>Level: {{ auth()->user()->profile->level }}</div>
        <div>XP: {{ auth()->user()->profile->xp }}</div>
        <div>Coins: {{ auth()->user()->profile->coins }}</div>
        <div>Points: {{ auth()->user()->profile->points }}</div>
    </div>

    <a href="/quests" class="block mt-6 bg-purple-600 text-white p-3 rounded">
        Mulai Quest
    </a>
</div>
</x-app-layout>