<x-mobile-shell title="Shop - PuzzleClass">
    <div class="px-5 pt-2 pb-28">
        <div class="text-[10px] tracking-[0.35em] text-gray-400 uppercase">Shop</div>

        <div class="flex justify-between items-start mt-3">
            <div>
                <h1 class="text-4xl font-black">Shop</h1>
            </div>

            <div class="bg-emerald-400 rounded-full px-4 py-2 shadow-sm">
                <span class="font-black text-white">🪙 {{ optional($user->profile)->coins ?? 0 }}</span>
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
                        <div class="text-3xl">
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

                    <button class="bg-emerald-400 text-white rounded-full px-4 py-2 font-bold">
                        {{ $item->price }}
                    </button>
                </form>
            @endforeach
        </div>
    </div>

    <x-bottom-nav />
</x-mobile-shell>