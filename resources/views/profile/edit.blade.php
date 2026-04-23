<x-mobile-shell title="Edit Profile - PuzzleClass">
    <div class="px-5 pt-6 pb-28">
        <div class="mt-4 text-center">
            @if(optional($user->profile)->avatar_url)
                <img
                    src="{{ $user->profile->avatar_url }}"
                    alt="Avatar"
                    class="w-24 h-24 rounded-full object-cover mx-auto shadow-lg border-4 border-white"
                    onerror="this.style.display='none'; document.getElementById('avatar-fallback-edit').style.display='flex';"
                >

                <div
                    id="avatar-fallback-edit"
                    class="w-24 h-24 rounded-full bg-violet-600 mx-auto shadow-lg items-center justify-center text-white text-3xl"
                    style="display:none;"
                >
                    👤
                </div>
            @else
                <div class="w-24 h-24 rounded-full bg-violet-600 mx-auto shadow-lg flex items-center justify-center text-white text-3xl">
                    👤
                </div>
            @endif

            <h1 class="text-3xl font-black mt-4">{{ $user->name }}</h1>
            <p class="text-gray-400 mt-1">Ubah profil akunmu</p>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="mt-4 bg-green-100 text-green-700 px-4 py-3 rounded-2xl font-semibold">
                Profil berhasil diperbarui.
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
            @csrf
            @method('patch')

            <div class="bg-white rounded-[20px] p-4 shadow-sm">
                <label class="block text-sm text-gray-400 mb-2">Foto Profil</label>
                <input type="file" name="avatar" class="w-full text-sm">
                @error('avatar')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-white rounded-[20px] p-4 shadow-sm">
                <label class="block text-sm text-gray-400 mb-2">Nama</label>
                <input
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    class="w-full border-0 focus:ring-0 p-0 text-lg font-semibold"
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-white rounded-[20px] p-4 shadow-sm">
                <label class="block text-sm text-gray-400 mb-2">Email</label>
                <input
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full border-0 focus:ring-0 p-0 text-lg font-semibold"
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button class="w-full bg-black text-white rounded-[18px] py-4 font-bold">
                Simpan Perubahan
            </button>
        </form>

        <div class="mt-6 bg-white rounded-[20px] p-4 shadow-sm">
            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-3">
                @csrf
                @method('delete')

                <div class="text-lg font-bold text-red-500">Hapus Akun</div>
                <p class="text-sm text-gray-400">Masukkan password untuk menghapus akun permanen.</p>

                <input
                    name="password"
                    type="password"
                    placeholder="Password"
                    class="w-full rounded-xl border px-4 py-3"
                >

                <button class="w-full bg-red-500 text-white rounded-[18px] py-3 font-bold">
                    Hapus Akun
                </button>
            </form>
        </div>
    </div>

    <x-bottom-nav />
</x-mobile-shell>