<x-mobile-shell title="Puzzle - PuzzleClass">
    <div class="px-5 pt-6 pb-28">
        @if($questCompleted)
            <div class="bg-white rounded-[28px] p-8 shadow-sm mt-6 text-center">
                <div class="text-5xl">🏆</div>
                <h1 class="text-3xl font-black mt-4">Quest Selesai</h1>
                <p class="text-gray-500 mt-2">{{ $quest->title }} sudah kamu tuntaskan hari ini.</p>

                <a href="{{ route('quests.index') }}" class="mt-5 inline-flex bg-black text-white rounded-[18px] px-6 py-3 font-bold">
                    Kembali ke Quest
                </a>
            </div>
        @else
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-4xl font-black leading-tight">Puzzle<br>Question</h1>
                    <p class="text-sm text-gray-400 mt-2">Soal {{ $currentStep }}/{{ $totalSteps }}</p>
                </div>

                <div class="relative">
                    <button id="power-menu-button" type="button" class="bg-emerald-400 rounded-[24px] px-5 py-4 text-center shadow-sm">
                        <div class="text-sm text-white/80">Power</div>
                        <div class="text-4xl">⚡</div>
                    </button>

                    <div id="power-menu" class="hidden absolute right-0 mt-3 w-52 bg-white rounded-[22px] shadow-xl p-3 z-50 space-y-2">
                        <form method="POST" action="{{ route('puzzle.hint', $puzzle) }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-between bg-yellow-50 rounded-2xl px-4 py-3 font-bold">
                                <span>💡 Hint</span>
                                <span class="text-sm text-gray-500">{{ optional(auth()->user()->profile)->hints ?? 0 }}</span>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('puzzle.use-time', [$puzzle, 15]) }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-between bg-blue-50 rounded-2xl px-4 py-3 font-bold">
                                <span>⏱️ +15s</span>
                                <span class="text-sm text-gray-500">{{ optional(auth()->user()->profile)->time_boost_15 ?? 0 }}</span>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('puzzle.use-time', [$puzzle, 30]) }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-between bg-purple-50 rounded-2xl px-4 py-3 font-bold">
                                <span>⏱️ +30s</span>
                                <span class="text-sm text-gray-500">{{ optional(auth()->user()->profile)->time_boost_30 ?? 0 }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

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

            @if(session('hint_text'))
                <div class="mt-4 bg-yellow-50 text-yellow-700 rounded-[20px] p-4 shadow-sm">
                    Hint: {{ session('hint_text') }}
                </div>
            @endif

            <div class="mt-4 bg-gray-200 rounded-full h-3 overflow-hidden">
                <div class="bg-violet-500 h-full rounded-full transition-all duration-300"
                     style="width: {{ intval(($currentStep / $totalSteps) * 100) }}%"></div>
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

            <form id="timeout-form" method="POST" action="{{ route('puzzle.timeout', $puzzle) }}" class="hidden">
                @csrf
            </form>

            <button form="answer-form" type="submit" class="mt-4 w-full bg-black text-white rounded-[18px] py-4 font-bold">
                Jawab
            </button>
        @endif
    </div>

    <x-bottom-nav />

    @if(!$questCompleted)
        <script>
            const powerButton = document.getElementById('power-menu-button');
            const powerMenu = document.getElementById('power-menu');

            powerButton.addEventListener('click', () => {
                powerMenu.classList.toggle('hidden');
            });

            let seconds = {{ $timeLeft }} + {{ session('time_boost_used', 0) }};
            const timerEl = document.getElementById('timer-display');
            const timeoutForm = document.getElementById('timeout-form');
            let submitted = false;

            function formatTime(totalSeconds) {
                const mins = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
                const secs = String(totalSeconds % 60).padStart(2, '0');
                return `${mins}:${secs}`;
            }

            timerEl.textContent = formatTime(seconds);

            const interval = setInterval(() => {
                seconds--;

                if (seconds <= 0) {
                    clearInterval(interval);
                    timerEl.textContent = '00:00';

                    if (!submitted) {
                        submitted = true;
                        timeoutForm.submit();
                    }

                    return;
                }

                timerEl.textContent = formatTime(seconds);
            }, 1000);
        </script>
    @endif
</x-mobile-shell>