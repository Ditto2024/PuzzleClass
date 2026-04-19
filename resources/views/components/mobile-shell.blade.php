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
</body>
</html>