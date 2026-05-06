<x-mobile-shell title="Shop - PuzzleClass">
    <div class="px-5 pt-6 pb-28">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-4xl font-black">Shop</h1>
            </div>

            <div class="bg-emerald-400 rounded-full px-4 py-3 shadow-sm flex items-center gap-2">
                <span class="inline-flex w-7 h-7 rounded-full bg-yellow-400 border-4 border-yellow-500 items-center justify-center text-xs font-black text-yellow-900">
                    C
                </span>
                <span class="font-black text-white text-xl">{{ optional($user->profile)->coins ?? 0 }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="mt-4 bg-green-100 text-green-700 px-4 py-3 rounded-2xl font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mt-4 bg-red-100 text-red-600 px-4 py-3 rounded-2xl font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-4 mt-6">
            @foreach($items as $item)
                <form method="POST" action="{{ route('shop.buy', $item) }}" class="bg-white rounded-[24px] px-5 py-4 shadow-sm flex items-center justify-between">
                    @csrf

                    <div class="flex items-center gap-4">
                        <div class="text-4xl">
                            @if($item->type === 'time_boost')
                                ⏱️
                            @elseif($item->type === 'hint')
                                💡
                            @else
                                🎁
                            @endif
                        </div>

                        <div>
                            <div class="text-xl font-bold">{{ $item->name }}</div>
                            <div class="text-sm text-gray-400">
                                @if($item->type === 'time_boost')
                                    Booster bantuan puzzle
                                @else
                                    Bantuan puzzle
                                @endif
                            </div>
                        </div>
                    </div>

                    <button class="bg-emerald-400 text-white rounded-full px-5 py-3 font-black flex items-center gap-2">
                        <span class="inline-flex w-5 h-5 rounded-full bg-yellow-400 border-2 border-yellow-500 items-center justify-center text-[10px] font-black text-yellow-900">
                            C
                        </span>
                        <span>{{ $item->price }}</span>
                    </button>
                </form>
            @endforeach
        </div>
    </div>

    <x-bottom-nav />
</x-mobile-shell>