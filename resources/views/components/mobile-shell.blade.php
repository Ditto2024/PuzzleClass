@props(['title' => 'PuzzleClass'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#eaf3fb] min-h-screen">
    <div class="max-w-[380px] mx-auto min-h-screen bg-[#f7f7f8] relative shadow-2xl overflow-hidden">
        {{ $slot }}
    </div>

    @auth
        @if(optional(auth()->user()->profile)->music_enabled)
            <audio id="bg-music" loop preload="auto">
                <source src="{{ asset('audio/kicaumania.mp3') }}" type="audio/mpeg">
            </audio>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const music = document.getElementById('bg-music');
                    if (!music) return;

                    music.volume = 0.25;

                    const savedTime = localStorage.getItem('puzzleclass_music_time');
                    if (savedTime) {
                        music.currentTime = parseFloat(savedTime);
                    }

                    function playMusic() {
                        music.play().catch(() => {});
                    }

                    document.addEventListener('click', playMusic, { once: true });

                    setInterval(() => {
                        if (!music.paused) {
                            localStorage.setItem('puzzleclass_music_time', music.currentTime);
                        }
                    }, 1000);
                });
            </script>
        @endif
    @endauth
</body>
</html>