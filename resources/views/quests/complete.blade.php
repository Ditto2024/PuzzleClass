<x-mobile-shell title="Quest Complete">
    <div class="px-5 pt-10 pb-28 text-center relative overflow-hidden">
        <canvas id="confetti-canvas" class="absolute inset-0 w-full h-full pointer-events-none"></canvas>

        <div class="text-6xl animate-bounce relative z-10">🎉</div>

        <h1 class="text-3xl font-black mt-4 relative z-10">
            Quest Selesai!
        </h1>

        <p class="text-gray-400 mt-2 relative z-10">
            {{ $quest->title }}
        </p>

        <div class="bg-white rounded-[28px] p-6 mt-6 shadow-lg space-y-4 relative z-10">
            <div class="text-xl font-bold text-gray-500">
                Hasil kamu:
            </div>

            <div class="text-2xl font-black">
                {{ session('correct') }}/5 Benar
            </div>

            <div class="grid grid-cols-3 gap-3 mt-4">
                <div class="bg-emerald-100 rounded-xl p-3">
                    <div class="text-2xl">💰</div>
                    <div class="font-bold text-green-600">
                        +{{ session('coins') }}
                    </div>
                </div>

                <div class="bg-violet-100 rounded-xl p-3">
                    <div class="text-2xl">⭐</div>
                    <div class="font-bold text-violet-600">
                        +{{ session('xp') }}
                    </div>
                </div>

                <div class="bg-yellow-100 rounded-xl p-3">
                    <div class="text-2xl">🏆</div>
                    <div class="font-bold text-yellow-600">
                        +{{ session('points') }}
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('quests.index') }}"
           class="mt-6 inline-block bg-black text-white px-6 py-3 rounded-xl font-bold relative z-10">
            Lanjut Quest →
        </a>
    </div>

    <x-bottom-nav />

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('confetti-canvas');
            const ctx = canvas.getContext('2d');

            function resize() {
                canvas.width = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;
            }

            resize();
            window.addEventListener('resize', resize);

            const pieces = Array.from({ length: 120 }, () => ({
                x: Math.random() * canvas.width,
                y: Math.random() * -canvas.height,
                r: Math.random() * 6 + 3,
                d: Math.random() * 120 + 40,
                color: ['#8b5cf6', '#22c55e', '#f59e0b', '#ef4444', '#3b82f6'][Math.floor(Math.random() * 5)],
                tilt: Math.random() * 10 - 10,
            }));

            let frame = 0;

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                pieces.forEach((p, i) => {
                    ctx.beginPath();
                    ctx.fillStyle = p.color;
                    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2, false);
                    ctx.fill();

                    p.y += p.d / 60;
                    p.x += Math.sin(frame / 12 + i) * 0.8;

                    if (p.y > canvas.height + 10) {
                        p.y = -10;
                        p.x = Math.random() * canvas.width;
                    }
                });

                frame++;
                if (frame < 260) requestAnimationFrame(draw);
            }

            draw();
        });
    </script>
</x-mobile-shell>