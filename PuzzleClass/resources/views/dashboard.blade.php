<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold">PuzzleClass Dashboard</h1>

        <p class="mt-2">Halo, {{ auth()->user()->name }}</p>

        <div class="mt-4 space-y-2">
            <div>Level: {{ auth()->user()->profile->level ?? 1 }}</div>
            <div>XP: {{ auth()->user()->profile->xp ?? 0 }}</div>
            <div>Coins: {{ auth()->user()->profile->coins ?? 0 }}</div>
            <div>Points: {{ auth()->user()->profile->points ?? 0 }}</div>
        </div>
    </div>
</x-app-layout>