<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PuzzleClass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f4f6] flex items-center justify-center min-h-screen">

<div class="w-full max-w-[380px] px-6">
    <div id="login-card" class="bg-white rounded-[28px] shadow-lg p-6 text-center opacity-0 translate-y-6 transition-all duration-700">
        <h1 class="text-2xl font-black">PuzzleClass</h1>
        <p class="text-gray-400 mt-1 text-sm">Solve • Think • Escape</p>

        <div class="w-20 h-20 bg-violet-600 rounded-2xl mx-auto mt-6 flex items-center justify-center text-white text-3xl shadow-lg">
            👤
        </div>

        <h2 class="text-xl font-bold mt-4">Welcome Back</h2>
        <p class="text-gray-400 text-sm">Masuk untuk melanjutkan puzzle</p>

        @if (session('status'))
            <div class="mt-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl px-4 py-3 text-sm font-medium text-left">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-4 bg-red-50 border border-red-200 rounded-2xl px-4 py-3 text-left">
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

        <form id="login-form" method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf

            <input
                type="email"
                name="email"
                placeholder="Email"
                value="{{ old('email') }}"
                class="w-full rounded-xl border px-4 py-3 focus:outline-none"
                required
                autofocus
            >

            <div class="relative">
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Password"
                    class="w-full rounded-xl border px-4 py-3 focus:outline-none pr-16"
                    required
                >
                <button
                    type="button"
                    id="toggle-password"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-gray-500 font-semibold"
                >
                    Show
                </button>
            </div>

            <button id="login-button" class="w-full bg-black text-white rounded-xl py-3 font-bold flex items-center justify-center gap-2">
                <span id="login-button-text">Masuk</span>
                <svg id="login-spinner" class="hidden w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </button>
        </form>

        <p class="text-sm text-gray-500 mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-violet-600 font-bold">Daftar</a>
        </p>
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

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            togglePassword.textContent = isPassword ? 'Hide' : 'Show';
        });
    }

    const loginForm = document.getElementById('login-form');
    const loginButton = document.getElementById('login-button');
    const loginButtonText = document.getElementById('login-button-text');
    const loginSpinner = document.getElementById('login-spinner');

    if (loginForm) {
        loginForm.addEventListener('submit', () => {
            loginButton.disabled = true;
            loginButton.classList.add('opacity-80', 'cursor-not-allowed');
            loginButtonText.textContent = 'Masuk...';
            loginSpinner.classList.remove('hidden');
        });
    }
</script>

</body>
</html>