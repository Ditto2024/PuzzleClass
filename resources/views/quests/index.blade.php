<x-mobile-shell title="Quest - PuzzleClass">
    <div class="px-5 pt-2 pb-28">
        @if($quests->first())
            <div class="bg-white rounded-[24px] p-5 shadow-sm">
                <div class="text-sm text-gray-400">Daily Mission</div>
                <div class="flex items-center justify-between mt-1">
                    <h2 class="text-2xl font-black">1 Puzzle • {{ $quests->first()->reward_points }} Poin</h2>
                    <div class="text-2xl">🎯</div>
                </div>

                <div class="mt-4 bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-emerald-400 h-full w-1/3 rounded-full"></div>
                </div>
            </div>
        @endif

        <h1 class="text-3xl font-black mt-6 mb-4">Quest Tersedia</h1>

        <div class="space-y-4">
            @foreach($quests as $index => $quest)
                @php
                    $states = ['Done', 'Start', 'Start'];
                    $colors = ['bg-green-100 text-green-700', 'bg-violet-100 text-violet-600', 'bg-violet-100 text-violet-600'];
                    $difficulty = ['Easy', 'Medium', 'Hard'];
                    $label = $states[$index] ?? 'Start';
                    $color = $colors[$index] ?? 'bg-violet-100 text-violet-600';
                    $diff = $difficulty[$index] ?? 'Medium';
                @endphp

                <div class="bg-white rounded-[24px] p-5 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-xl font-bold">{{ $quest->title }}</div>
                        <div class="text-sm text-gray-400 mt-1">Difficulty: {{ $diff }}</div>
                    </div>

                    <a href="{{ route('quests.show', $quest) }}" class="px-4 py-2 rounded-full text-sm font-bold {{ $color }}">
                        {{ $label }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <x-bottom-nav />
</x-mobile-shell>