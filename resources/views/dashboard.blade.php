<x-mobile-shell title="Dashboard - PuzzleClass">
    <div class="px-5 pt-6 pb-32">
        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-2xl font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 text-red-600 px-4 py-3 rounded-2xl font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <p class="text-lg text-gray-500 leading-snug">
                    Selamat<br>datang<br>kembali 👋
                </p>
                <h1 class="text-4xl font-black mt-2 truncate">{{ $user->name }}</h1>
            </div>

            <div class="bg-white rounded-[22px] px-5 py-4 shadow-sm min-w-[105px] text-center shrink-0">
                <div class="text-sm text-gray-400">Coins</div>
                <div class="text-4xl font-black text-green-500 leading-none mt-1">
                    {{ optional($user->profile)->coins ?? 0 }}
                </div>
            </div>
        </div>

        <div class="mt-6 rounded-[28px] bg-gradient-to-r from-violet-600 to-violet-400 text-white p-6 shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-base opacity-90">Level {{ $level }} Explorer</p>
                    <p class="text-5xl font-black mt-4 leading-tight">
                        XP {{ $currentXp }} / {{ $xpTarget }}
                    </p>
                </div>

                <div class="text-5xl">🔥</div>
            </div>

            <div class="mt-5 bg-white/30 h-3 rounded-full overflow-hidden">
                <div class="h-full bg-white rounded-full" style="width: {{ $xpPercent }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6">
            <div class="bg-white rounded-[26px] p-5 shadow-sm min-h-[170px]">
                <div class="text-base text-gray-400">Daily Reward</div>
                <div class="text-4xl font-black mt-5 leading-tight">
                    +50<br>Coins
                </div>

                @if($canClaimDailyReward)
                    <form method="POST" action="{{ route('daily-reward.claim') }}">
                        @csrf
                        <button class="mt-5 bg-emerald-400 text-white px-6 py-3 rounded-full font-bold">
                            Claim
                        </button>
                    </form>
                @else
                    <button disabled class="mt-5 bg-gray-300 text-white px-6 py-3 rounded-full font-bold">
                        Claimed
                    </button>
                @endif
            </div>

            <div class="bg-white rounded-[26px] p-5 shadow-sm min-h-[170px]">
                <div class="text-base text-gray-400">Streak</div>
                <div class="text-4xl font-black mt-5 leading-tight">
                    {{ optional($profile)->streak_count ?? 0 }} Hari 🔥
                </div>
                <div class="text-sm text-gray-400 mt-4">Jaga ritme belajarmu</div>
            </div>
        </div>

        @if($quests->first())
            <div class="mt-6 bg-white rounded-[26px] p-5 shadow-sm">
                <div class="text-base text-gray-400">Daily Mission</div>

                <div class="flex items-start justify-between gap-3 mt-2">
                    <div>
                        <h3 class="text-2xl font-black leading-tight">{{ $quests->first()->title }}</h3>
                        <p class="text-sm text-gray-400 mt-1">
                            {{ $quests->first()->reward_points }} poin • {{ $quests->first()->puzzles->count() }} soal
                        </p>
                    </div>

                    <div class="text-3xl shrink-0">🎯</div>
                </div>

                <div class="mt-4 bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-emerald-400 h-full rounded-full"
                         style="width: {{ $quests->first()->daily_progress_percent ?? 0 }}%"></div>
                </div>

                <div class="text-xs text-gray-400 mt-2">
                    Progress hari ini: {{ $quests->first()->daily_progress_percent ?? 0 }}%
                </div>
            </div>
        @endif

    <x-bottom-nav />
</x-mobile-shell>