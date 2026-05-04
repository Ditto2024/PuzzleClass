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
                    Selamat datang kembali 👋
                </p>
                <h1 class="text-4xl font-black mt-2 truncate">{{ $user->name }}</h1>
            </div>

            <div class="bg-white rounded-[22px] px-5 py-4 shadow-sm min-w-[105px] text-center shrink-0">
                <div class="text-sm text-gray-400">Coins</div>
                <div class="flex items-center justify-center gap-1 mt-1">
                    <span class="text-xl">🪙</span>
                    <span class="text-4xl font-black text-green-500 leading-none">
                        {{ optional($user->profile)->coins ?? 0 }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-6 rounded-[30px] bg-gradient-to-br from-violet-600 via-violet-500 to-purple-400 text-white p-6 shadow-xl relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
            <div class="absolute -right-10 bottom-0 w-40 h-40 rounded-full bg-black/10"></div>

            <div class="relative z-10">
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

                <div class="mt-4 flex justify-between text-sm text-white/80">
                    <span>Progress level</span>
                    <span>{{ intval($xpPercent) }}%</span>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-black rounded-[28px] p-5 text-white shadow-lg">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="text-sm text-white/60">Continue Learning</div>
                    <div class="text-2xl font-black mt-1">
                        {{ $quests->first()->title ?? 'Mulai Quest' }}
                    </div>
                    <div class="text-sm text-white/60 mt-1">
                        Latih algoritma hari ini
                    </div>
                </div>

                <a href="{{ route('quests.index') }}" class="bg-violet-600 text-white rounded-full px-5 py-3 font-bold shrink-0">
                    Mulai
                </a>
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
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-base text-gray-400">Daily Mission</div>
                        <h3 class="text-2xl font-black leading-tight mt-2">
                            Selesaikan {{ $quests->first()->puzzles->count() }} Soal
                        </h3>
                        <p class="text-sm text-gray-400 mt-1">
                            Dapatkan {{ $quests->first()->reward_points }} poin hari ini
                        </p>
                    </div>

                    <div class="text-4xl">🎯</div>
                </div>

                <div class="mt-4 bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-emerald-400 h-full rounded-full"
                         style="width: {{ $quests->first()->daily_progress_percent ?? 0 }}%"></div>
                </div>

                <div class="mt-3 flex items-center justify-between text-xs text-gray-400">
                    <span>Progress hari ini</span>
                    <span>{{ $quests->first()->daily_progress_percent ?? 0 }}%</span>
                </div>
            </div>
        @endif

        <div class="mt-6 grid grid-cols-3 gap-3">
            <a href="{{ route('quests.index') }}" class="bg-white rounded-[22px] p-4 shadow-sm text-center">
                <div class="text-3xl">🧩</div>
                <div class="font-bold text-sm mt-2">Quest</div>
            </a>

            <a href="{{ route('shop.index') }}" class="bg-white rounded-[22px] p-4 shadow-sm text-center">
                <div class="text-3xl">🛒</div>
                <div class="font-bold text-sm mt-2">Shop</div>
            </a>

            <a href="{{ route('leaderboard.index') }}" class="bg-white rounded-[22px] p-4 shadow-sm text-center">
                <div class="text-3xl">🏆</div>
                <div class="font-bold text-sm mt-2">Rank</div>
            </a>
        </div>

        <div class="mt-6 bg-[#fff7dd] rounded-[24px] p-5 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="text-3xl">💡</div>
                <div>
                    <div class="font-black text-lg">Tips Hari Ini</div>
                    <p class="text-sm text-gray-500 mt-1">
                        Algoritma adalah langkah-langkah terurut untuk menyelesaikan masalah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <x-bottom-nav />
</x-mobile-shell>