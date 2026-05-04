<x-mobile-shell title="Quest - PuzzleClass">
    <div class="px-5 pt-6 pb-32">
        @if($quests->first())
            <div class="bg-white rounded-[24px] p-5 shadow-sm">
                <div class="text-sm text-gray-400">Daily Mission</div>
                <div class="flex items-center justify-between mt-1">
                    <h2 class="text-2xl font-black">1 Puzzle • {{ $quests->first()->reward_points }} Poin</h2>
                    <div class="text-2xl">🎯</div>
                </div>

                <div class="mt-4 bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-emerald-400 h-full rounded-full"
                         style="width: {{ $quests->first()->progress_percent ?? 0 }}%"></div>
                </div>
            </div>
        @endif

        <h1 class="text-3xl font-black mt-6 mb-4">Quest Tersedia</h1>

        <div class="space-y-4">
            @foreach($quests as $quest)
                @php
                    $status = $quest->ui_status ?? 'Start';

                    $btnClass = match($status) {
                        'Done' => 'bg-green-100 text-green-700',
                        'Locked' => 'bg-gray-200 text-gray-500',
                        default => 'bg-violet-100 text-violet-600',
                    };

                    $btnText = match($status) {
                        'Done' => 'Done',
                        'Locked' => '🔒',
                        default => 'Start',
                    };
                @endphp

                <div class="bg-white rounded-[24px] p-5 shadow-sm {{ $status === 'Locked' ? 'opacity-60' : '' }}">
                    <div class="flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="text-xl font-bold truncate">{{ $quest->title }}</div>
                            <div class="text-sm text-gray-400 mt-1">{{ $quest->description }}</div>
                        </div>

                        @if($status === 'Locked')
                            <button disabled class="px-5 py-3 rounded-full text-sm font-bold {{ $btnClass }}">
                                {{ $btnText }}
                            </button>
                        @else
                            <a href="{{ route('quests.show', $quest) }}"
                               class="px-5 py-3 rounded-full text-sm font-bold {{ $btnClass }}">
                                {{ $btnText }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-4 bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div class="bg-emerald-400 h-full rounded-full"
                             style="width: {{ $quest->progress_percent ?? 0 }}%"></div>
                    </div>

                    @if($status === 'Locked')
                        <div class="text-xs text-gray-400 mt-2">
                            Selesaikan quest sebelumnya dulu.
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <x-bottom-nav />
</x-mobile-shell>