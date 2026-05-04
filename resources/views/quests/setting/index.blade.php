<x-mobile-shell title="Settings - PuzzleClass">
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
                    <div class="text-sm text-gray-400">Aktifkan suara benar/salah</div>
                </div>

                <input
                    type="checkbox"
                    name="sound_enabled"
                    value="1"
                    {{ optional($user->profile)->sound_enabled ? 'checked' : '' }}
                >
            </div>

            <div class="bg-white rounded-[22px] p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="font-bold text-lg">Dark Mode</div>
                    <div class="text-sm text-gray-400">Preferensi tampilan gelap</div>
                </div>

                <input
                    type="checkbox"
                    name="dark_mode"
                    value="1"
                    {{ optional($user->profile)->dark_mode ? 'checked' : '' }}
                >
            </div>

            <button class="w-full bg-black text-white rounded-[18px] py-4 font-bold">
                Simpan Settings
            </button>
        </form>
    </div>

    <x-bottom-nav />
</x-mobile-shell>