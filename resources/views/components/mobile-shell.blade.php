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

            <button
                id="music-toggle"
                type="button"
                class="fixed top-4 right-4 z-[9999] bg-black text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center text-xl"
            >
                🎵
            </button>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const music = document.getElementById('bg-music');
                    const button = document.getElementById('music-toggle');

                    if (!music || !button) return;

                    music.volume = 0.25;

                    let isPlaying = false;

                    function playMusic() {
                        music.play().then(() => {
                            isPlaying = true;
                            button.textContent = '🔊';
                        }).catch(() => {
                            isPlaying = false;
                            button.textContent = '🎵';
                        });
                    }

                    function pauseMusic() {
                        music.pause();
                        isPlaying = false;
                        button.textContent = '🔇';
                    }

                    button.addEventListener('click', () => {
                        if (isPlaying) {
                            pauseMusic();
                        } else {
                            playMusic();
                        }
                    });

                    document.addEventListener('click', () => {
                        if (!isPlaying) {
                            playMusic();
                        }
                    }, { once: true });
                });
            </script>
        @endif
    @endauth
</body>
</html>