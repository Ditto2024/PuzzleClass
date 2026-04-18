<x-app-layout>
    <div class="min-h-screen bg-gray-100 pb-24">
        <div class="max-w-md mx-auto p-4">
            <div class="bg-white rounded-2xl shadow p-5 mb-4">
                <p class="text-sm text-gray-500">Halo, selamat datang kembali</p>
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>

                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Level</p>
                        <p class="text-xl font-bold">{{ $level }}</p>
                    </div>

                    <div class="text-right">
                        <p class="text-sm text-gray-500">Coins</p>
                        <p class="text-xl font-bold text-purple-600">
                            {{ optional($user->profile)->coins ?? 0 }}
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500">XP</span>
                        <span class="font-medium">{{ $currentXp }} / {{ $xpTarget }}</span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div
                            class="bg-purple-600 h-3 rounded-full transition-all duration-300"
                            style="width: {{ $xpPercent }}%;"
                        ></div>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="bg-purple-50 rounded-xl p-4">
                        <p class="text-sm text-gray-500">Points</p>
                        <p class="text-xl font-bold text-gray-900">
                            {{ optional($user->profile)->points ?? 0 }}
                        </p>
                    </div>

                    <div class="bg-yellow-50 rounded-xl p-4">
                        <p class="text-sm text-gray-500">Hints</p>
                        <p class="text-xl font-bold text-gray-900">
                            {{ optional($user->profile)->hints ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-5 mb-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold">Progress Puzzle</h2>
                    <a href="{{ route('quests.index') }}" class="text-sm text-purple-600 font-semibold">
                        Lihat semua
                    </a>
                </div>

                @if ($quests->count())
                    <div class="space-y-3">
                        @foreach ($quests as $quest)
                            <div class="border rounded-xl p-4">
                                <div class="flex justify-between items-start gap-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $quest->title }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">{{ $quest->description }}</p>
                                    </div>

                                    <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 font-medium">
                                        Open
                                    </span>
                                </div>

                                <div class="mt-3 flex gap-4 text-sm">
                                    <span class="text-purple-600 font-semibold">+{{ $quest->reward_points }} poin</span>
                                    <span class="text-yellow-600 font-semibold">+{{ $quest->reward_xp }} XP</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Belum ada quest tersedia.</p>
                @endif
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-sm">
            <div class="max-w-md mx-auto grid grid-cols-4 text-center py-3">
                <a href="{{ route('dashboard') }}" class="text-purple-600 font-semibold text-sm">
                    Home
                </a>
                <a href="{{ route('quests.index') }}" class="text-gray-500 text-sm">
                    Quest
                </a>
                <span class="text-gray-400 text-sm">Shop</span>
                <a href="{{ route('profile.edit') }}" class="text-gray-500 text-sm">
                    Profile
                </a>
            </div>
        </div>
    </div>
</x-app-layout>