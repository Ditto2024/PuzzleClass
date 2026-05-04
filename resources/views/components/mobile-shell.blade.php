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
        <audio id="bg-music" loop preload="auto">
            <source src="{{ asset('audio/kicaumania.mp3') }}" type="audio/mpeg">
        </audio>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const music = document.getElementById('bg-music');
                const musicButton = document.getElementById('music-toggle');

                if (!music) return;

                music.volume = 0.25;

                const savedTime = localStorage.getItem('puzzleclass_music_time');
                if (savedTime) {
                    music.currentTime = parseFloat(savedTime);
                }

                function updateButton() {
                    if (!musicButton) return;
                    musicButton.textContent = localStorage.getItem('puzzleclass_music_enabled') === 'true' ? '🔊' : '🎵';
                }

                function playMusic() {
                    localStorage.setItem('puzzleclass_music_enabled', 'true');

                    music.play().then(() => {
                        updateButton();
                    }).catch(() => {
                        updateButton();
                    });
                }

                function pauseMusic() {
                    music.pause();
                    localStorage.setItem('puzzleclass_music_enabled', 'false');
                    updateButton();
                }

                if (musicButton) {
                    musicButton.addEventListener('click', () => {
                        if (localStorage.getItem('puzzleclass_music_enabled') === 'true' && !music.paused) {
                            pauseMusic();
                        } else {
                            playMusic();
                        }
                    });
                }

                document.addEventListener('click', () => {
                    if (localStorage.getItem('puzzleclass_music_enabled') === 'true') {
                        playMusic();
                    }
                }, { once: true });

                if (localStorage.getItem('puzzleclass_music_enabled') === 'true') {
                    playMusic();
                }

                setInterval(() => {
                    if (!music.paused) {
                        localStorage.setItem('puzzleclass_music_time', music.currentTime);
                    }
                }, 1000);

                updateButton();
            });
        </script>
    @endauth
</body>
</html>