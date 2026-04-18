<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold">PuzzleClass Dashboard</h1>

        <p class="mt-2">Halo, {{ auth()->user()->name }}</p>

        <div class="mt-6 grid grid-cols-2 gap-4">
            <div class="border p-4 rounded">
                <p>Level</p>
                <p class="text-xl font-bold">
                    {{ optional(auth()->user()->profile)->level ?? 1 }}
                </p>
            </div>

            <div class="border p-4 rounded">
                <p>XP</p>
                <p class="text-xl font-bold">
                    {{ optional(auth()->user()->profile)->xp ?? 0 }}
                </p>
            </div>

            <div class="border p-4 rounded">
                <p>Coins</p>
                <p class="text-xl font-bold">
                    {{ optional(auth()->user()->profile)->coins ?? 0 }}
                </p>
            </div>

            <div class="border p-4 rounded">
                <p>Points</p>
                <p class="text-xl font-bold">
                    {{ optional(auth()->user()->profile)->points ?? 0 }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>