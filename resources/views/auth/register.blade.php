<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PuzzleClass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f4f6] flex items-center justify-center min-h-screen">

<div class="w-full max-w-[380px] px-6">

    <div id="register-card" class="bg-white rounded-[28px] shadow-lg p-6 text-center opacity-0 translate-y-6 transition-all duration-700">
        <h1 class="text-2xl font-black">PuzzleClass</h1>

        <div class="w-20 h-20 bg-violet-600 rounded-2xl mx-auto mt-6 flex items-center justify-center text-white text-3xl shadow-lg">
            👤
        </div>

        <h2 class="text-xl font-bold mt-4">Create Account</h2>

        @if ($errors->any())
            <div class="mt-4 bg-red-50 border border-red-200 rounded-2xl px-4 py-3 text-left">
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

        <form id="register-form" method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
            @csrf

            <input
                type="text"
                name="name"
                placeholder="Nama"
                value="{{ old('name') }}"
                class="w-full rounded-xl border px-4 py-3"
                required
                autofocus
            >

            <input
                type="email"
                name="email"
                placeholder="Email"
                value="{{ old('email') }}"
                class="w-full rounded-xl border px-4 py-3"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Password"
                class="w-full rounded-xl border px-4 py-3"
                required
            >

            <input
                type="password"
                name="password_confirmation"
                placeholder="Konfirmasi Password"
                class="w-full rounded-xl border px-4 py-3"
                required
            >

            <button id="register-button" class="w-full bg-black text-white rounded-xl py-3 font-bold flex items-center justify-center gap-2">
                <span id="register-button-text">Daftar</span>
                <svg id="register-spinner" class="hidden w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </button>
        </form>

        <p class="text-sm text-gray-500 mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-violet-600 font-bold">Masuk</a>
        </p>
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

    if (registerForm) {
        registerForm.addEventListener('submit', () => {
            registerButton.disabled = true;
            registerButton.classList.add('opacity-80', 'cursor-not-allowed');
            registerButtonText.textContent = 'Daftar...';
            registerSpinner.classList.remove('hidden');
        });
    }
</script>

</body>
</html>