@php
    $route = request()->route()?->getName();
@endphp

<div class="fixed bottom-0 left-0 right-0">
    <div class="max-w-[380px] mx-auto px-4 pb-4">
        <div class="bg-black rounded-[22px] px-2 py-2 grid grid-cols-4 text-center shadow-xl">
            <a href="{{ route('dashboard') }}" class="rounded-2xl py-2 {{ $route === 'dashboard' ? 'bg-violet-600 text-white' : 'text-gray-300' }}">
                <div class="text-lg">🏠</div>
                <div class="text-[11px]">Home</div>
            </a>

            <a href="{{ route('quests.index') }}" class="rounded-2xl py-2 {{ str_starts_with($route ?? '', 'quests') ? 'bg-violet-600 text-white' : 'text-gray-300' }}">
                <div class="text-lg">🧩</div>
                <div class="text-[11px]">Quest</div>
            </a>

            <a href="{{ route('shop.index') }}" class="rounded-2xl py-2 {{ str_starts_with($route ?? '', 'shop') ? 'bg-violet-600 text-white' : 'text-gray-300' }}">
                <div class="text-lg">🛒</div>
                <div class="text-[11px]">Shop</div>
            </a>

            <a href="{{ route('profile.page') }}" class="rounded-2xl py-2 {{ str_starts_with($route ?? '', 'profile.page') || str_starts_with($route ?? '', 'leaderboard') ? 'bg-violet-600 text-white' : 'text-gray-300' }}">
                <div class="text-lg">👤</div>
                <div class="text-[11px]">Profile</div>
            </a>
        </div>
    </div>
</div>