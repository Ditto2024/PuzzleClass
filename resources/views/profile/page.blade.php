<x-mobile-shell title="Profile - PuzzleClass">
    <div class="px-5 pt-2 pb-28">
        <div class="text-center">
            <div class="w-24 h-24 rounded-full bg-violet-600 mx-auto shadow-lg"></div>
            <h1 class="text-3xl font-black mt-4">{{ $user->name }}</h1>
            <p class="text-gray-400 mt-1">Level {{ optional($user->profile)->level ?? 1 }} Explorer</p>
        </div>

        <div class="mt-5 bg-white rounded-[24px] p-5 shadow-sm">
            <div class="flex justify-between text-sm mb-2">
                <span>XP</span>
                <span>{{ optional($user->profile)->xp ?? 0 }} / 200</span>
            </div>

            <div class="bg-gray-200 h-3 rounded-full overflow-hidden">
                <div class="bg-violet-500 h-full rounded-full" style="width: 60%"></div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-5">
            <div class="bg-white rounded-[22px] p-5 shadow-sm text-center">
                <div class="text-3xl font-black">{{ optional($user->profile)->points ?? 0 }}</div>
                <div class="text-sm text-gray-400 mt-1">Puzzle Selesai</div>
            </div>

            <div class="bg-white rounded-[22px] p-5 shadow-sm text-center">
                <div class="text-3xl font-black">3 🔥</div>
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