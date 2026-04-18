<x-mobile-shell title="Puzzle - PuzzleClass">
    <div class="px-5 pt-2 pb-28">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-[10px] tracking-[0.35em] text-gray-400 uppercase">Puzzle Screen</div>
                <h1 class="text-4xl font-black mt-3 leading-tight">Puzzle<br>Question</h1>
            </div>

            <div class="bg-emerald-400 rounded-[24px] px-5 py-4 text-center shadow-sm">
                <div class="text-2xl">🪙</div>
                <div class="text-2xl font-black text-white">{{ optional(auth()->user()->profile)->coins ?? 0 }}</div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-5">
            <div class="bg-white rounded-[24px] p-4 shadow-sm">
                <div class="text-sm text-gray-400">Time Left</div>
                <div class="text-4xl font-black text-rose-500 mt-2">01:30</div>
            </div>

            <div class="bg-white rounded-[24px] p-4 shadow-sm">
                <div class="text-sm text-gray-400">Combo</div>
                <div class="text-4xl font-black text-orange-500 mt-2">x2 🔥</div>
            </div>
        </div>

        <div class="mt-5 bg-[#f8f4df] rounded-[28px] p-8 shadow-sm text-center">
            <div class="text-6xl">🧩</div>
            <p class="mt-5 text-2xl font-semibold text-gray-800">
                {{ $puzzle->question }}
            </p>
        </div>

        <form method="POST" action="{{ route('puzzle.answer', $puzzle) }}" class="mt-5">
            @csrf

            @php
                $options = ['aaaaa', 'bbbbb', 'ccccc'];
            @endphp

            <div class="space-y-3">
                @foreach($options as $option)
                    <label class="block">
                        <input type="radio" name="answer" value="{{ $option }}" class="hidden peer">
                        <div class="rounded-[18px] bg-white border border-gray-100 px-5 py-4 text-lg shadow-sm peer-checked:bg-emerald-50 peer-checked:border-emerald-300 peer-checked:text-emerald-700">
                            {{ $option }}
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="grid grid-cols-2 gap-3 mt-4">
                <button type="button" class="bg-amber-400 rounded-[18px] py-4 font-bold text-gray-900">
                    💡 Hint (20)
                </button>

                <button type="submit" class="bg-black text-white rounded-[18px] py-4 font-bold">
                    Continue
                </button>
            </div>
        </form>

        @if(session('result'))
            <div class="mt-4 bg-white rounded-[20px] p-4 shadow-sm">
                <div class="{{ session('result') === 'Benar!' ? 'text-green-600' : 'text-red-500' }} font-bold text-lg">
                    {{ session('result') }}
                </div>

                @if(session('result') === 'Benar!')
                    <div class="text-sm text-emerald-500 mt-2">
                        +50 XP • +20 Coins • lanjut ke puzzle berikutnya
                    </div>
                @endif
            </div>
        @endif
    </div>

    <x-bottom-nav />
</x-mobile-shell>