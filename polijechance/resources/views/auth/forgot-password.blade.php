<x-guest-layout>
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md rounded-lg">

        <h2 class="text-2xl font-bold text-center text-blue-600 mb-4">Lupa Password</h2>

        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('Masukkan email Anda, kami akan mengirimkan link untuk mengatur ulang password.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email"
    class="block mt-1 w-full bg-white dark:bg-white text-gray-900 dark:text-gray-900 border border-blue-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50"
    type="email"
    name="email"
    :value="old('email')"
    required
    autofocus />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end">
                <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white">
                    {{ __('Kirim Link Reset') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
