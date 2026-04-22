<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PuzzleClass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#eef4fb] min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-[390px]">
        <div id="login-card"
             class="bg-white rounded-[32px] shadow-[0_20px_60px_rgba(0,0,0,0.12)] p-6 opacity-0 translate-y-6 transition-all duration-700">

            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] tracking-[0.35em] text-gray-400 uppercase">Login Screen</p>
                    <h1 class="text-4xl font-black mt-3 leading-none">PuzzleClass</h1>
                    <p class="text-sm text-gray-400 mt-1">Solve • Think • Escape</p>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-violet-600 flex items-center justify-center text-white text-2xl shadow-lg">
                    🍩
                </div>
            </div>

            <div class="mt-8 rounded-[28px] bg-[#fafafa] border border-gray-100 p-6 text-center shadow-sm">
                <div class="w-20 h-20 bg-violet-600 rounded-[24px] mx-auto flex items-center justify-center text-white text-4xl shadow-lg">
                    👤
                </div>

                <h2 class="text-3xl font-black mt-5">Welcome Back</h2>
                <p class="text-gray-400 text-sm mt-2">Masuk untuk melanjutkan puzzle harianmu</p>
            </div>

            @if (session('status'))
                <div class="mt-5 bg-green-50 border border-green-200 text-green-700 rounded-2xl px-4 py-3 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-5 bg-red-50 border border-red-200 rounded-2xl px-4 py-3">
                    <div class="flex items-start gap-3">
                        <div class="text-red-500 text-lg">⚠️</div>
                        <div class="text-sm text-red-600">
                            <div class="font-semibold mb-1">Login gagal</div>
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form id="login-form" method="POST" action="{{ route('login') }}" class="mt-5 space-y-4">
                @csrf

                <div class="bg-white rounded-[20px] border border-gray-100 px-4 py-3 shadow-sm">
                    <label class="block text-xs text-gray-400 mb-1">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="ditto.class@email.com"
                        class="w-full border-0 p-0 focus:ring-0 font-semibold text-gray-700 bg-transparent"
                        required
                        autofocus
                    >
                </div>

                <div class="bg-white rounded-[20px] border border-gray-100 px-4 py-3 shadow-sm">
                    <label class="block text-xs text-gray-400 mb-1">Password</label>
                    <div class="flex items-center gap-2">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full border-0 p-0 focus:ring-0 font-semibold text-gray-700 bg-transparent"
                            required
                        >
                        <button type="button" id="toggle-password" class="text-gray-400 text-sm font-semibold">
                            Show
                        </button>
                    </div>
                </div>

                <button id="login-button"
                        type="submit"
                        class="w-full bg-black text-white rounded-[18px] py-4 font-bold shadow-md transition hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2">
                    <span id="login-button-text">Masuk</span>
                    <svg id="login-spinner" class="hidden w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </form>

            <div class="mt-4">
                <a href="{{ route('register') }}"
                   class="w-full block text-center bg-white rounded-[18px] py-4 font-semibold shadow-sm border border-gray-100 hover:bg-gray-50 transition">
                    Masuk dengan Google
                </a>
            </div>

            <div class="text-center mt-5 text-sm text-gray-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-violet-600 font-bold">Daftar</a>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const card = document.getElementById('login-card');
            setTimeout(() => {
                card.classList.remove('opacity-0', 'translate-y-6');
            }, 120);
        });

        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            togglePassword.textContent = isPassword ? 'Hide' : 'Show';
        });

        const loginForm = document.getElementById('login-form');
        const loginButton = document.getElementById('login-button');
        const loginButtonText = document.getElementById('login-button-text');
        const loginSpinner = document.getElementById('login-spinner');

        loginForm.addEventListener('submit', () => {
            loginButton.disabled = true;
            loginButton.classList.add('opacity-80', 'cursor-not-allowed');
            loginButtonText.textContent = 'Masuk...';
            loginSpinner.classList.remove('hidden');
        });
    </script>
</body>
</html>