<x-mobile-shell title="Settings - PuzzleClass">
    @php
        $profile = $user->profile;
    @endphp

    <div class="px-5 pt-6 pb-28">
        <h1 class="text-4xl font-black">Settings</h1>
        <p class="text-gray-400 mt-1">Atur pengalaman bermainmu</p>

        @if(session('success'))
            <div class="mt-4 bg-green-100 text-green-700 px-4 py-3 rounded-2xl font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('settings.update') }}" class="mt-6 space-y-4">
            @csrf
            @method('patch')

            <div class="bg-white rounded-[22px] p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="font-bold text-lg">Sound Effect</div>
                    <div class="text-sm text-gray-400">Suara benar, salah, dan reward</div>
                </div>

                <input type="checkbox" name="sound_enabled" value="1"
                    {{ ($profile->sound_enabled ?? true) ? 'checked' : '' }}>
            </div>

            <div class="bg-white rounded-[22px] p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="font-bold text-lg">Background Music</div>
                    <div class="text-sm text-gray-400">Musik latar saat bermain</div>
                </div>

                <input type="checkbox" name="music_enabled" value="1"
                    {{ ($profile->music_enabled ?? false) ? 'checked' : '' }}>
            </div>

            <div class="bg-white rounded-[22px] p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="font-bold text-lg">Dark Mode</div>
                    <div class="text-sm text-gray-400">Mode gelap untuk tampilan</div>
                </div>

                <input type="checkbox" name="dark_mode" value="1"
                    {{ ($profile->dark_mode ?? false) ? 'checked' : '' }}>
            </div>

            <div class="bg-white rounded-[22px] p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="font-bold text-lg">Auto Next</div>
                    <div class="text-sm text-gray-400">Lanjut otomatis setelah menjawab</div>
                </div>

                <input type="checkbox" name="auto_next_enabled" value="1"
                    {{ ($profile->auto_next_enabled ?? true) ? 'checked' : '' }}>
            </div>

            <button class="w-full bg-black text-white rounded-[18px] py-4 font-bold">
                Simpan Settings
            </button>
        </form>

        <div class="mt-6 bg-white rounded-[24px] p-5 shadow-sm">
            <h2 class="text-xl font-black">Info Item</h2>

            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="bg-yellow-50 rounded-2xl p-4 text-center">
                    <div class="text-3xl">💡</div>
                    <div class="font-black mt-1">{{ $profile->hints ?? 0 }}</div>
                    <div class="text-sm text-gray-400">Hint tersedia</div>
                </div>

                <div class="bg-blue-50 rounded-2xl p-4 text-center">
                    <div class="text-3xl">⏱️</div>
                    <div class="font-black mt-1">{{ $profile->time_boost_15 ?? 0 }}</div>
                    <div class="text-sm text-gray-400">+15 detik</div>
                </div>
            </div>
        </div>
    </div>

    <x-bottom-nav />
</x-mobile-shell>