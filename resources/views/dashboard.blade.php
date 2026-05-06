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

        <div class="flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-base text-gray-500 leading-snug">
                    Selamat datang kembali 👋
                </p>
                <h1 class="text-4xl font-black mt-2 truncate">
                    {{ $user->name }}
                </h1>
            </div>

            <div class="bg-white rounded-[22px] px-4 py-3 shadow-sm w-[120px] text-center shrink-0">
                <div class="text-sm text-gray-400">Coins</div>
                <div class="flex items-center justify-center gap-2 mt-1">
                    <span class="inline-flex w-7 h-7 rounded-full bg-yellow-400 border-4 border-yellow-500 items-center justify-center text-xs font-black text-yellow-900">
                        C
                    </span>
                    <span class="text-3xl font-black text-green-500 leading-none">
                        {{ optional($user->profile)->coins ?? 0 }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-6 rounded-[30px] bg-gradient-to-br from-violet-600 via-violet-500 to-purple-400 text-white p-6 shadow-xl relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
            <div class="absolute -right-10 bottom-0 w-40 h-40 rounded-full bg-black/10"></div>

            <div class="relative z-10">
                <div class="flex justify-between items-start gap-3">
                    <div class="min-w-0">
                        <p class="text-base opacity-90">Level {{ $level }} Explorer</p>
                        <p class="text-4xl font-black mt-4 leading-tight">
                            XP {{ $currentXp }} / {{ $xpTarget }}
                        </p>
                    </div>

                    <div class="text-5xl shrink-0">🔥</div>
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

        <div class="mt-6 bg-white rounded-[28px] p-5 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <div class="text-sm text-gray-400">Materi Hari Ini</div>

                    <h2 class="text-2xl font-black mt-2">
                        📘 Algoritma Dasar
                    </h2>

                    <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                        Algoritma adalah langkah-langkah terurut untuk menyelesaikan masalah.
                    </p>
                </div>

                <div class="text-5xl shrink-0">🧠</div>
            </div>

            <div class="mt-5">
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-400">Progress Belajar</span>
                    <span class="font-bold text-violet-600">75%</span>
                </div>

                <div class="bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-violet-500 h-full rounded-full w-[75%]"></div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-5">
                <button onclick="openMaterial()"
                    class="bg-gray-100 rounded-[18px] py-4 font-bold">
                    📖 Baca Materi
                </button>

                <a href="{{ route('quests.index') }}"
                   class="bg-violet-600 text-white rounded-[18px] py-4 text-center font-bold">
                    🚀 Start Quest
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

                    <div class="text-4xl shrink-0">🎯</div>
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

        <div class="mt-6 bg-[#fff7dd] rounded-[24px] p-5 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="text-3xl">💡</div>
                <div>
                    <div class="font-black text-lg">Tips Hari Ini</div>
                    <p class="text-sm text-gray-500 mt-1">
                        Algoritma membantu kita menyelesaikan masalah secara runtut, jelas, dan terarah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="material-modal"
         class="hidden fixed inset-0 bg-black/40 z-50 flex items-end justify-center">

        <div class="bg-white w-full max-w-[380px] rounded-t-[30px] p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-black">
                    📘 Algoritma Dasar
                </h2>

                <button onclick="closeMaterial()" class="text-2xl">
                    ✖
                </button>
            </div>

            <div class="mt-5 space-y-4 text-gray-600 leading-relaxed">
                <p>
                    Algoritma adalah langkah-langkah terurut untuk menyelesaikan suatu masalah.
                </p>

                <p>
                    Contoh algoritma membuat mie:
                </p>

                <ol class="list-decimal pl-5 space-y-2">
                    <li>Panaskan air</li>
                    <li>Masukkan mie</li>
                    <li>Tunggu 3 menit</li>
                    <li>Masukkan bumbu</li>
                    <li>Sajikan</li>
                </ol>

                <div class="bg-violet-50 rounded-2xl p-4 mt-4">
                    <div class="font-bold text-violet-700">
                        💡 Kesimpulan
                    </div>

                    <p class="text-sm mt-2 text-violet-600">
                        Algoritma membuat penyelesaian masalah menjadi lebih mudah dipahami.
                    </p>
                </div>
            </div>

            <button onclick="closeMaterial()"
                class="w-full mt-6 bg-violet-600 text-white rounded-[18px] py-4 font-bold">
                Saya Mengerti
            </button>
        </div>
    </div>

    <x-bottom-nav />

    <script>
        function openMaterial() {
            document.getElementById('material-modal').classList.remove('hidden');
        }

        function closeMaterial() {
            document.getElementById('material-modal').classList.add('hidden');
        }
    </script>
</x-mobile-shell>