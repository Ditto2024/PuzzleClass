<x-mobile-shell title="Dashboard - PuzzleClass">
    <div class="px-5 pt-6 pb-28">
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

                @if($canClaimDailyReward)
                    <form method="POST" action="{{ route('daily-reward.claim') }}">
                        @csrf
                        <button class="mt-4 bg-emerald-400 text-white px-5 py-2 rounded-full font-bold">Claim</button>
                    </form>
                @else
                    <button disabled class="mt-4 bg-gray-300 text-white px-5 py-2 rounded-full font-bold">Claimed</button>
                @endif
            </div>

            <div class="bg-white rounded-[24px] p-5 shadow-sm">
                <div class="text-sm text-gray-400">Streak</div>
                <div class="text-3xl font-black mt-2">{{ optional($profile)->streak_count ?? 0 }} Hari 🔥</div>
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

        <div class="mt-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-2xl font-black">Quest Tersedia</h2>
                <a href="{{ route('quests.index') }}" class="text-violet-600 font-semibold text-sm">
                    Lihat semua
                </a>
            </div>

            <div class="space-y-4">
                @forelse($quests as $quest)
                    <div class="bg-white rounded-[24px] p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-xl font-bold">{{ $quest->title }}</div>
                                <div class="text-sm text-gray-400 mt-1">{{ $quest->description }}</div>
                            </div>

                            <a href="{{ route('quests.show', $quest) }}" class="px-4 py-2 rounded-full text-sm font-bold bg-violet-100 text-violet-600">
                                Start
                            </a>
                        </div>

                        <div class="mt-4 bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="bg-emerald-400 h-full w-1/3 rounded-full"></div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-[24px] p-5 shadow-sm text-gray-400">
                        Belum ada quest tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <x-bottom-nav />
</x-mobile-shell>