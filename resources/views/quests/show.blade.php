<x-mobile-shell title="Puzzle - PuzzleClass">
    <div class="px-5 pt-6 pb-28">
        @if($questCompleted)
            <div class="bg-white rounded-[28px] p-8 shadow-sm mt-6 text-center">
                <div class="text-5xl">🏆</div>
                <h1 class="text-3xl font-black mt-4">Quest Selesai</h1>
                <p class="text-gray-500 mt-2">{{ $quest->title }} sudah kamu tuntaskan.</p>

                <a href="{{ route('quests.index') }}" class="mt-5 inline-flex bg-black text-white rounded-[18px] px-6 py-3 font-bold">
                    Kembali ke Quest
                </a>
            </div>
        @else
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-4xl font-black leading-tight">Puzzle<br>Question</h1>
                </div>

                <div class="bg-emerald-400 rounded-[24px] px-5 py-4 text-center shadow-sm">
                    <div class="text-2xl">🪙</div>
                    <div class="text-2xl font-black text-white">{{ optional(auth()->user()->profile)->coins ?? 0 }}</div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-5">
                <div class="bg-white rounded-[24px] p-4 shadow-sm">
                    <div class="text-sm text-gray-400">Time Left</div>
                    <div id="timer-display" class="text-4xl font-black text-rose-500 mt-2">
                        {{ gmdate('i:s', $timeLeft) }}
                    </div>
                </div>

                <div class="bg-white rounded-[24px] p-4 shadow-sm">
                    <div class="text-sm text-gray-400">Combo</div>
                    <div class="text-4xl font-black text-orange-500 mt-2">x{{ $comboCount }} 🔥</div>
                </div>
            </div>

            <div class="mt-5 bg-[#f8f4df] rounded-[28px] p-8 shadow-sm text-center">
                <div class="text-6xl">🧩</div>
                <p class="mt-5 text-2xl font-semibold text-gray-800">{{ $puzzle->question }}</p>
            </div>

            <form id="answer-form" method="POST" action="{{ route('puzzle.answer', $puzzle) }}" class="mt-5">
                @csrf

                <div class="space-y-3">
                    @foreach($answerOptions as $option)
                        <label class="block">
                            <input type="radio" name="answer" value="{{ $option }}" class="hidden peer" required>
                            <div class="rounded-[18px] bg-white border border-gray-100 px-5 py-4 text-lg shadow-sm peer-checked:bg-emerald-50 peer-checked:border-emerald-300 peer-checked:text-emerald-700">
                                {{ $option }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </form>

            <div class="grid grid-cols-2 gap-3 mt-4">
                <form method="POST" action="{{ route('puzzle.hint', $puzzle) }}">
                    @csrf
                    <button type="submit" class="w-full bg-amber-400 rounded-[18px] py-4 font-bold text-gray-900">
                        💡 Hint (20)
                    </button>
                </form>

                <button form="answer-form" type="submit" class="bg-black text-white rounded-[18px] py-4 font-bold">
                    Continue
                </button>
            </div>

            @if(session('hint_text'))
                <div class="mt-4 bg-yellow-50 text-yellow-700 rounded-[20px] p-4 shadow-sm">
                    Hint: {{ session('hint_text') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mt-4 bg-green-50 text-green-700 rounded-[20px] p-4 shadow-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 bg-red-50 text-red-600 rounded-[20px] p-4 shadow-sm font-semibold">
                    {{ session('error') }}
                </div>
            @endif
        @endif
    </div>

    <x-bottom-nav />

    @if(!$questCompleted)
        <script>
            let seconds = {{ $timeLeft }};
            const timerEl = document.getElementById('timer-display');

            function formatTime(totalSeconds) {
                const mins = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
                const secs = String(totalSeconds % 60).padStart(2, '0');
                return `${mins}:${secs}`;
            }

            const interval = setInterval(() => {
                seconds--;

                if (seconds < 0) {
                    clearInterval(interval);
                    timerEl.textContent = '00:00';
                    return;
                }

                timerEl.textContent = formatTime(seconds);
            }, 1000);
        </script>
    @endif
</x-mobile-shell>