@extends('layouts.guest')

@section('title', 'Login Admin')

@section('content')
    <div class="w-full">
        {{-- FORM WRAPPER --}}
        <div class="w-full max-w-md mx-auto px-5">
            <h1 class="text-xl md:text-2xl font-bold">Qiyana Bouquet</h1>
            <div class="space-y-1 pt-16">
                <h1 class="text-xl md:text-2xl font-bold">Welcome Back!👋</h1>
                <p class="text-sm">Silahkan login ke akun Anda</p>
            </div>
            <form method="POST" action="{{ route('login') }}" class="space-y-6 py-5">
                @csrf
                {{-- SINGLE INPUT --}}
                <div id="input-group">
                    <x-input-label for="email" :value="__('Email')" />
                    <div class="relative">
                        <div class="absolute top-1/2 left-0 transform -translate-y-1/2 z-10 ml-5 mt-0.5">
                            <iconify-icon icon="clarity:email-line" width="20" height="20"></iconify-icon>
                        </div>
                        <x-text-input id="email" class="w-full placeholder-gray-400 pl-12 pr-4 py-3" type="email" name="email" :value="old('email')" placeholder="Masukkan email Anda"  />
                    </div>
                    <x-input-error id="input-error" :messages="$errors->get('email')" class="mt-2" />
                </div>
                {{-- SINGLE INPUT --}}
                <div id="input-group" class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <div class="relative">
                        <div class="absolute top-1/2 left-0 transform -translate-y-1/2 z-10 ml-5 mt-0.5">
                            <iconify-icon icon="teenyicons:password-outline" width="20" height="20"></iconify-icon>
                        </div>
                        <x-text-input id="password" class="w-full placeholder-gray-400 pl-12 pr-4 py-3" type="password" name="password" placeholder="Masukkan password Anda"  />
                    </div>
                    <x-input-error id="input-error" :messages="$errors->get('password')" class="mt-2" />
                </div>
                {{-- REMEMBER ME --}}
                <div class="flex justify-between items-center mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-pink-primary shadow-sm focus:ring-pink-primary" name="remember">
                        <span class="ms-2 text-sm text-gray-600 font-bold">{{ __('Remember me') }}</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-pink-primary" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
                {{-- BUTTON --}}
                <div class="flex mt-4">
                    <div class="w-full relative rounded-full">
                        <x-primary-button type="submit" class="w-full">Log In</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection