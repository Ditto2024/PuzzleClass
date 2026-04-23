<x-mobile-shell title="Leaderboard - PuzzleClass">
    <div class="px-5 pt-6 pb-28">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black">Leaderboard</h1>
            </div>

            <a href="{{ route('profile.page') }}" class="bg-white rounded-full px-4 py-2 shadow-sm text-sm">
                Close
            </a>
        </div>

        <div class="mt-5 bg-[#fdf8e8] rounded-[24px] p-5 shadow-sm">
            <div class="text-sm text-gray-400">Posisimu saat ini</div>
            <div class="flex justify-between items-center mt-2">
                <div>
                    <div class="text-4xl font-black">#{{ $rank ?? '-' }} {{ $user->name }}</div>
                    <div class="text-green-500 font-semibold mt-1">Naik 1 peringkat ↑</div>
                </div>
                <div class="text-4xl">🏅</div>
            </div>
        </div>

        <div class="space-y-4 mt-5">
            @foreach($leaders as $index => $leader)
                <div class="bg-white rounded-[22px] p-4 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="text-2xl">
                            @if($index === 0) 🥇
                            @elseif($index === 1) 🥈
                            @else 🥉
                            @endif
                        </div>

                        <div>
                            <div class="font-bold text-lg">{{ $leader->name }}</div>
                            <div class="text-sm text-gray-400">{{ optional($leader->profile)->points ?? 0 }} pts</div>
                        </div>
                    </div>

                    <div class="bg-violet-100 text-violet-600 px-3 py-2 rounded-full text-sm font-bold">
                        Logic Master
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <x-bottom-nav />
</x-mobile-shell>