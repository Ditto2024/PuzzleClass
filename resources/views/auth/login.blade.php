<x-mobile-shell title="Login - PuzzleClass">
    <div class="px-6 pt-2 pb-28">
        <div class="text-[10px] tracking-[0.35em] text-gray-400 uppercase">Login Screen</div>

        <div class="flex items-start justify-between mt-3">
            <div>
                <h1 class="text-4xl font-black leading-none">PuzzleClass</h1>
                <p class="text-sm text-gray-500 mt-1">Solve • Think • Escape</p>
            </div>

            <div class="w-14 h-14 bg-violet-600 rounded-2xl flex items-center justify-center text-2xl shadow-lg">
                🍩
            </div>
        </div>

        <div class="mt-7 rounded-[28px] bg-white shadow-md px-6 py-8 text-center">
            <div class="w-20 h-20 mx-auto rounded-3xl bg-violet-600 flex items-center justify-center text-4xl shadow-lg">
                👤
            </div>

            <h2 class="mt-5 text-3xl font-bold">Welcome Back</h2>
            <p class="mt-2 text-sm text-gray-500">Masuk untuk melanjutkan puzzle harianmu</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="mt-5 space-y-4">
            @csrf

            <div class="bg-white rounded-[20px] border border-gray-100 px-4 py-3 shadow-sm">
                <label class="block text-xs text-gray-400 mb-1">Username</label>
                <input name="email" type="email" value="{{ old('email') }}" class="w-full border-0 p-0 focus:ring-0 font-semibold text-gray-700" placeholder="ditto.class" required autofocus>
            </div>

            <div class="bg-white rounded-[20px] border border-gray-100 px-4 py-3 shadow-sm">
                <label class="block text-xs text-gray-400 mb-1">Password</label>
                <input name="password" type="password" class="w-full border-0 p-0 focus:ring-0 font-semibold text-gray-700" placeholder="••••••••" required>
            </div>

            <button class="w-full bg-black text-white rounded-[18px] py-4 font-bold shadow-md">
                Masuk
            </button>
        </form>

        <div class="mt-4">
            <a href="{{ route('register') }}" class="w-full block text-center bg-white rounded-[18px] py-4 font-semibold shadow-sm">
                Masuk dengan Google
            </a>
        </div>

        <div class="text-center mt-5 text-sm text-gray-400">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-violet-600 font-semibold">Daftar</a>
        </div>
    </div>
</x-mobile-shell>