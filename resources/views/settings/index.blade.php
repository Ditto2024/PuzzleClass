<x-mobile-shell title="Settings - PuzzleClass">
    @php
        $profile = $user->profile;
    @endphp

    <div class="px-5 pt-6 pb-32">
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

            <label class="bg-white rounded-[22px] p-5 shadow-sm flex items-center justify-between gap-4">
                <div>
                    <div class="font-bold text-lg">Sound Effect</div>
                    <div class="text-sm text-gray-400">Suara benar, salah, dan reward</div>
                </div>

                <input type="checkbox" name="sound_enabled" value="1"
                    class="w-5 h-5 shrink-0"
                    {{ ($profile->sound_enabled ?? true) ? 'checked' : '' }}>
            </label>

            <label class="bg-white rounded-[22px] p-5 shadow-sm flex items-center justify-between gap-4">
                <div>
                    <div class="font-bold text-lg">Dark Mode</div>
                    <div class="text-sm text-gray-400">Mode gelap untuk tampilan</div>
                </div>

                <input type="checkbox" name="dark_mode" value="1"
                    class="w-5 h-5 shrink-0"
                    {{ ($profile->dark_mode ?? false) ? 'checked' : '' }}>
            </label>

            <label class="bg-white rounded-[22px] p-5 shadow-sm flex items-center justify-between gap-4">
                <div>
                    <div class="font-bold text-lg">Auto Next</div>
                    <div class="text-sm text-gray-400">Lanjut otomatis setelah menjawab</div>
                </div>

                <input type="checkbox" name="auto_next_enabled" value="1"
                    class="w-5 h-5 shrink-0"
                    {{ ($profile->auto_next_enabled ?? true) ? 'checked' : '' }}>
            </label>

            <button class="w-full bg-black text-white rounded-[18px] py-4 font-bold">
                Simpan Settings
            </button>
        </form>
    </div>

    <x-bottom-nav />
</x-mobile-shell>