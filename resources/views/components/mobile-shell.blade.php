@props(['title' => 'PuzzleClass'])

@php
    $isDark = auth()->check() && optional(auth()->user()->profile)->dark_mode;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if($isDark)
        <style>
            body {
                background: #020617 !important;
            }

            .app-shell {
                background: #0f172a !important;
                color: #f8fafc !important;
            }

            .app-shell .bg-white {
                background: #1e293b !important;
                color: #f8fafc !important;
            }

            .app-shell .text-gray-400,
            .app-shell .text-gray-500 {
                color: #94a3b8 !important;
            }

            .app-shell .bg-gray-200 {
                background: #334155 !important;
            }

            .app-shell input {
                background: #0f172a !important;
                color: #f8fafc !important;
                border-color: #334155 !important;
            }

            .app-shell .shadow-sm,
            .app-shell .shadow-lg,
            .app-shell .shadow-xl {
                box-shadow: 0 15px 30px rgba(0,0,0,0.35) !important;
            }
        </style>
    @endif
</head>

<body class="{{ $isDark ? 'bg-slate-950' : 'bg-[#eaf3fb]' }} min-h-screen">
    <div class="app-shell max-w-[380px] mx-auto min-h-screen {{ $isDark ? 'bg-slate-900 text-white' : 'bg-[#f7f7f8]' }} relative shadow-2xl overflow-hidden">
        {{ $slot }}
    </div>
</body>
</html>