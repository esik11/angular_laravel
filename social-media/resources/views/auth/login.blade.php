<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-24 h-24 fill-current text-indigo-500 hover:text-indigo-700 transition duration-300" />
            </a>
        </x-slot>

        <!-- Social Media Login Title -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-100">Social Media Login</h1>
            <p class="mt-1 text-gray-400">Welcome back! Please login to continue.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email Address')" class="text-sm font-semibold text-gray-300" />
                <x-input id="email" class="block mt-2 w-full border-gray-600 bg-gray-800 text-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                         type="email" name="email" :value="old('email')" required autofocus placeholder="Enter your email" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-300" />
                <x-input id="password" class="block mt-2 w-full border-gray-600 bg-gray-800 text-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                         type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-600 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-500 hover:text-indigo-400 transition duration-300" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-300">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>

        <!-- Additional Links -->
        <div class="mt-6 text-center">
            <p class="text-gray-400 text-sm">Don't have an account? <a href="{{ route('register') }}" class="underline text-indigo-500 hover:text-indigo-700">Sign up here</a>.</p>
        </div>
    </x-auth-card>
</x-guest-layout>
