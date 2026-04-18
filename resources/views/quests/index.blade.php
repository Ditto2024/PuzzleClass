<x-app-layout>
    <div class="min-h-screen bg-gray-100 pb-24">
        <div class="max-w-md mx-auto p-4">
            <div class="bg-white rounded-2xl shadow p-5 mb-4">
                <h1 class="text-2xl font-bold">Quest Tersedia</h1>
                <p class="text-sm text-gray-500 mt-1">Selesaikan quest untuk mendapatkan poin dan XP.</p>
            </div>

            <div class="space-y-4">
                @forelse ($quests as $quest)
                    <div class="bg-white rounded-2xl shadow p-5">
                        <div class="flex justify-between items-start gap-3">
                            <div>
                                <h2 class="font-bold text-lg">{{ $quest->title }}</h2>
                                <p class="text-gray-500 text-sm mt-1">{{ $quest->description }}</p>
                            </div>

                            <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 font-medium">
                                Open
                            </span>
                        </div>

                        <div class="mt-4 flex gap-4 text-sm">
                            <span class="px-3 py-2 rounded-lg bg-purple-50 text-purple-700 font-semibold">
                                +{{ $quest->reward_points }} Poin
                            </span>
                            <span class="px-3 py-2 rounded-lg bg-yellow-50 text-yellow-700 font-semibold">
                                +{{ $quest->reward_xp }} XP
                            </span>
                        </div>

                        <div class="mt-4">
                            <button class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-xl">
                                Mulai Quest
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow p-5">
                        <p class="text-gray-500">Belum ada quest aktif.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-sm">
            <div class="max-w-md mx-auto grid grid-cols-4 text-center py-3">
                <a href="{{ route('dashboard') }}" class="text-gray-500 text-sm">
                    Home
                </a>
                <a href="{{ route('quests.index') }}" class="text-purple-600 font-semibold text-sm">
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