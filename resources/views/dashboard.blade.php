<x-mobile-shell title="Dashboard - PuzzleClass">
    <div class="px-5 pt-2 pb-28">
        <div class="text-[10px] tracking-[0.35em] text-gray-400 uppercase">Home Dashboard</div>

        <div class="mt-3 flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500">Selamat datang kembali 👋</p>
                <h1 class="text-4xl font-black mt-1">{{ $user->name }}</h1>
            </div>

            <div class="bg-white rounded-2xl px-4 py-3 shadow-sm min-w-[82px] text-center">
                <div class="text-xs text-gray-400">Coins</div>
                <div class="text-3xl font-black text-green-500">{{ optional($user->profile)->coins ?? 0 }}</div>
            </div>
        </div>

        <div class="mt-5 rounded-[26px] bg-gradient-to-r from-violet-600 to-violet-400 text-white p-5 shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm opacity-80">Level {{ $level }} Explorer</p>
                    <p class="text-4xl font-black mt-2">XP {{ $currentXp }} / {{ $xpTarget }}</p>
                </div>

                <div class="text-4xl">🔥</div>
            </div>

            <div class="mt-4 bg-white/30 h-3 rounded-full overflow-hidden">
                <div class="h-full bg-white rounded-full" style="width: {{ $xpPercent }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-5">
            <div class="bg-white rounded-[24px] p-5 shadow-sm">
                <div class="text-sm text-gray-400">Daily Reward</div>
                <div class="text-3xl font-black mt-2">+50 Coins</div>
                <button class="mt-4 bg-emerald-400 text-white px-5 py-2 rounded-full font-bold">Claim</button>
            </div>

            <div class="bg-white rounded-[24px] p-5 shadow-sm">
                <div class="text-sm text-gray-400">Streak</div>
                <div class="text-3xl font-black mt-2">3 Hari 🔥</div>
                <div class="text-xs text-gray-400 mt-2">Jaga ritme belajarmu</div>
            </div>
        </div>

        @if($quests->first())
            <div class="mt-5 bg-white rounded-[24px] p-5 shadow-sm">
                <div class="text-sm text-gray-400">Daily Mission</div>
                <div class="flex items-center justify-between mt-1">
                    <h3 class="text-2xl font-black">1 Puzzle • {{ $quests->first()->reward_points }} Poin</h3>
                    <div class="text-2xl">🎯</div>
                </div>

                <div class="mt-4 bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-emerald-400 h-full w-1/3 rounded-full"></div>
                </div>
            </div>
        @endif
    </div>

    <x-bottom-nav />
</x-mobile-shell>