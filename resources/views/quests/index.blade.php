<x-mobile-shell title="Quest - PuzzleClass">
    <div class="px-5 pt-2 pb-28">
        <div class="text-[10px] tracking-[0.35em] text-gray-400 uppercase">Quest Screen</div>

        @if($quests->first())
            <div class="mt-4 bg-white rounded-[24px] p-5 shadow-sm">
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
            @foreach($quests as $quest)
                @php
                    $btnClass = match($quest->ui_status ?? 'Start') {
                        'Done' => 'bg-green-100 text-green-700',
                        'Locked' => 'bg-gray-200 text-gray-500',
                        default => 'bg-violet-100 text-violet-600',
                    };
                @endphp

                <div class="bg-white rounded-[24px] p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xl font-bold">{{ $quest->title }}</div>
                            <div class="text-sm text-gray-400 mt-1">{{ $quest->description }}</div>
                        </div>

                        @if(($quest->ui_status ?? 'Start') === 'Locked')
                            <span class="px-4 py-2 rounded-full text-sm font-bold {{ $btnClass }}">
                                Locked
                            </span>
                        @else
                            <a href="{{ route('quests.show', $quest) }}" class="px-4 py-2 rounded-full text-sm font-bold {{ $btnClass }}">
                                {{ $quest->ui_status ?? 'Start' }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-4 bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div
                            class="bg-emerald-400 h-full rounded-full"
                            style="width: {{ $quest->progress_percent ?? 0 }}%"
                        ></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <x-bottom-nav />
</x-mobile-shell>