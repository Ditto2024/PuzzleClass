<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PuzzleClass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#eef4fb] min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-[390px]">
        <div id="register-card"
             class="bg-white rounded-[32px] shadow-[0_20px_60px_rgba(0,0,0,0.12)] p-6 opacity-0 translate-y-6 transition-all duration-700">

            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] tracking-[0.35em] text-gray-400 uppercase">Register Screen</p>
                    <h1 class="text-4xl font-black mt-3 leading-none">PuzzleClass</h1>
                    <p class="text-sm text-gray-400 mt-1">Solve • Think • Escape</p>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-violet-600 flex items-center justify-center text-white text-2xl shadow-lg">
                    ✨
                </div>
            </div>

            <div class="mt-8 rounded-[28px] bg-[#fafafa] border border-gray-100 p-6 text-center shadow-sm">
                <div class="w-20 h-20 bg-violet-600 rounded-[24px] mx-auto flex items-center justify-center text-white text-4xl shadow-lg">
                    👤
                </div>

                <h2 class="text-3xl font-black mt-5">Create Account</h2>
                <p class="text-gray-400 text-sm mt-2">Daftar untuk mulai petualangan puzzlemu</p>
            </div>

            @if ($errors->any())
                <div class="mt-5 bg-red-50 border border-red-200 rounded-2xl px-4 py-3">
                    <div class="flex items-start gap-3">
                        <div class="text-red-500 text-lg">⚠️</div>
                        <div class="text-sm text-red-600">
                            <div class="font-semibold mb-1">Register gagal</div>
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form id="register-form" method="POST" action="{{ route('register') }}" class="mt-5 space-y-4">
                @csrf

                <div class="bg-white rounded-[20px] border border-gray-100 px-4 py-3 shadow-sm">
                    <label class="block text-xs text-gray-400 mb-1">Nama</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Ditto"
                        class="w-full border-0 p-0 focus:ring-0 font-semibold text-gray-700 bg-transparent"
                        required
                        autofocus
                    >
                </div>

                <div class="bg-white rounded-[20px] border border-gray-100 px-4 py-3 shadow-sm">
                    <label class="block text-xs text-gray-400 mb-1">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="ditto.class@email.com"
                        class="w-full border-0 p-0 focus:ring-0 font-semibold text-gray-700 bg-transparent"
                        required
                    >
                </div>

                <div class="bg-white rounded-[20px] border border-gray-100 px-4 py-3 shadow-sm">
                    <label class="block text-xs text-gray-400 mb-1">Password</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        class="w-full border-0 p-0 focus:ring-0 font-semibold text-gray-700 bg-transparent"
                        required
                    >
                </div>

                <div class="bg-white rounded-[20px] border border-gray-100 px-4 py-3 shadow-sm">
                    <label class="block text-xs text-gray-400 mb-1">Konfirmasi Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="••••••••"
                        class="w-full border-0 p-0 focus:ring-0 font-semibold text-gray-700 bg-transparent"
                        required
                    >
                </div>

                <button id="register-button"
                        type="submit"
                        class="w-full bg-black text-white rounded-[18px] py-4 font-bold shadow-md transition hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2">
                    <span id="register-button-text">Daftar</span>
                    <svg id="register-spinner" class="hidden w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </form>

            <div class="text-center mt-5 text-sm text-gray-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-violet-600 font-bold">Masuk</a>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const card = document.getElementById('register-card');
            setTimeout(() => {
                card.classList.remove('opacity-0', 'translate-y-6');
            }, 120);
        });

        const registerForm = document.getElementById('register-form');
        const registerButton = document.getElementById('register-button');
        const registerButtonText = document.getElementById('register-button-text');
        const registerSpinner = document.getElementById('register-spinner');

        registerForm.addEventListener('submit', () => {
            registerButton.disabled = true;
            registerButton.classList.add('opacity-80', 'cursor-not-allowed');
            registerButtonText.textContent = 'Daftar...';
            registerSpinner.classList.remove('hidden');
        });
    </script>
</body>
</html>