<x-app-layout>
    <h1>{{ $quest->title }}</h1>

    <p>{{ $puzzle->question }}</p>

    <form method="POST" action="{{ route('puzzle.answer', $puzzle) }}">
        @csrf
        <input type="text" name="answer" required>
        <button type="submit">Jawab</button>
    </form>

    @if(session('result'))
        <p>{{ session('result') }}</p>
    @endif
</x-app-layout>