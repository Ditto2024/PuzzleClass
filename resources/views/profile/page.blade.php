<x-mobile-shell title="Profile - PuzzleClass">
    @php
        $profile = $user->profile;
        $xp = $profile->xp ?? 0;
        $level = $profile->level ?? 1;
        $target = $level * 200;
        $percent = $target > 0 ? min(100, ($xp / $target) * 100) : 0;
    @endphp

    <div class="px-5 pt-6 pb-28">
        <div class="text-center">
            @if($profile && $profile->avatar_url)
                <img
                    src="{{ $profile->avatar_url }}"
                    alt="Avatar"
                    class="w-24 h-24 rounded-full object-cover mx-auto shadow-lg border-4 border-white"
                    onerror="this.style.display='none'; document.getElementById('avatar-fallback-page').style.display='flex';"
                >
                <div
                    id="avatar-fallback-page"
                    class="w-24 h-24 rounded-full bg-gradient-to-br from-violet-600 to-violet-400 mx-auto shadow-lg items-center justify-center text-white text-3xl"
                    style="display:none;"
                >
                    👤
                </div>
            @else
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-violet-600 to-violet-400 mx-auto shadow-lg flex items-center justify-center text-white text-3xl">
                    👤
                </div>
            @endif

            <h1 class="text-3xl font-black mt-4">{{ $user->name }}</h1>
            <p class="text-gray-400 mt-1">Level {{ $level }} Explorer</p>
        </div>

        <div class="mt-5 bg-white rounded-[24px] p-5 shadow-sm">
            <div class="flex justify-between text-sm mb-2">
                <span>XP</span>
                <span>{{ $xp }} / {{ $target }}</span>
            </div>

            <div class="bg-gray-200 h-3 rounded-full overflow-hidden">
                <div
                    class="bg-violet-500 h-full rounded-full transition-all duration-300"
                    style="width: {{ $percent }}%"
                ></div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-5">
            <div class="bg-white rounded-[22px] p-5 shadow-sm text-center">
                <div class="text-3xl font-black">{{ $profile->puzzles_solved ?? 0 }}</div>
                <div class="text-sm text-gray-400 mt-1">Puzzle Selesai</div>
            </div>

            <div class="bg-white rounded-[22px] p-5 shadow-sm text-center">
                <div class="text-3xl font-black">{{ $profile->streak_count ?? 0 }} 🔥</div>
                <div class="text-sm text-gray-400 mt-1">Streak</div>
            </div>
        </div>

        <div class="space-y-3 mt-5">
            <a href="{{ route('profile.edit') }}" class="bg-white rounded-[20px] px-5 py-4 shadow-sm flex justify-between items-center">
                <span class="font-semibold">Edit Profil</span>
                <span>✏️</span>
            </a>

            <div class="bg-white rounded-[20px] px-5 py-4 shadow-sm flex justify-between items-center">
                <span class="font-semibold">Pengaturan</span>
                <span>⚙️</span>
            </div>

            <a href="{{ route('leaderboard.index') }}" class="bg-white rounded-[20px] px-5 py-4 shadow-sm flex justify-between items-center">
                <span class="font-semibold">Leaderboard</span>
                <span>🏆</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left bg-white rounded-[20px] px-5 py-4 shadow-sm flex justify-between items-center text-red-500 font-semibold">
                    <span>Logout</span>
                    <span>🚪</span>
                </button>
            </form>
        </div>
    </div>

    <x-bottom-nav />
</x-mobile-shell>