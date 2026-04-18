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

    <div class="bg-white rounded-[28px] shadow-lg p-6 text-center">
        <h1 class="text-2xl font-black">PuzzleClass</h1>

        <div class="w-20 h-20 bg-violet-600 rounded-2xl mx-auto mt-6 flex items-center justify-center text-white text-3xl">
            👤
        </div>

        <h2 class="text-xl font-bold mt-4">Create Account</h2>

        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
            @csrf

            <input type="text" name="name" placeholder="Nama"
                class="w-full rounded-xl border px-4 py-3">

            <input type="email" name="email" placeholder="Email"
                class="w-full rounded-xl border px-4 py-3">

            <input type="password" name="password" placeholder="Password"
                class="w-full rounded-xl border px-4 py-3">

            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                class="w-full rounded-xl border px-4 py-3">

            <button class="w-full bg-black text-white rounded-xl py-3 font-bold">
                Daftar
            </button>
        </form>

        <p class="text-sm text-gray-500 mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-violet-600 font-bold">Masuk</a>
        </p>
    </div>

</div>

</body>
</html>