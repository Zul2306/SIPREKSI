<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-blue-700">Daftar Akun</h1>
        <p class="text-gray-600">Silakan isi form di bawah untuk membuat akun baru</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input id="name" name="name" type="text" required autofocus
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none"
                value="{{ old('name') }}">
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-500" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
            <input id="email" name="email" type="email" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none"
                value="{{ old('email') }}">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-500" />
        </div>

        <!-- Kelas -->
        <div>
            <label for="kelas_id" class="block text-sm font-medium text-gray-700">Pilih Kelas</label>
            <select id="kelas_id" name="kelas_id" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('kelas_id')" class="mt-1 text-sm text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
            <input id="password" name="password" type="password" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Sandi</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-red-500" />
        </div>

        <div class="flex items-center justify-between">
            <a class="text-sm text-blue-600 hover:underline" href="{{ route('login') }}">
                Sudah punya akun?
            </a>
            <button type="submit"
            class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition duration-150 ease-in-out">
            Daftar
        </button>
        
        </div>
    </form>
</x-guest-layout>
