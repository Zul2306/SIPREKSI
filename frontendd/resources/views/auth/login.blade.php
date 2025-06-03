<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h2 class="text-center text-2xl font-semibold text-purple-600  mb-6">Selamat Datang</h2>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" class="mt-1 block w-full" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500" name="remember">
                <span class="ml-2 text-sm text-purple-600 ">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-teal-600 hover:text-teal-800" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif

            <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                {{ __('Login') }}
            </x-primary-button>
            
        </div>
    </form>
</x-guest-layout>
