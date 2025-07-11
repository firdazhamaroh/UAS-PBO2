<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        {{-- ICONIFY --}}
        <script src="https://code.iconify.design/iconify-icon/1.0.5/iconify-icon.min.js"></script>
        {{-- GOOGLE FONTS --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
        @stack('styles')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- APEXCHART --}}
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </head>
    <body x-cloak x-data="{ loaded: true, sidebarOpen: false }">
        {{-- START : LOADER --}}
        <div 
            x-show="loaded" 
            x-transition:enter="transition-opacity duration-700 ease-in" 
            x-transition:enter-start="opacity-0" 
            x-transition:enter-end="opacity-100" 
            x-transition:leave="transition-opacity duration-700 ease-out" 
            x-transition:leave-start="opacity-100" 
            x-transition:leave-end="opacity-0" 
            x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => loaded = false, 300) })" 
            class="grid place-items-center w-full h-screen bg-white bg-opacity-50 backdrop-blur-xl z-[60] fixed top-0 left-1/2 transform -translate-x-1/2">
            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="16" stroke-dashoffset="16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c4.97 0 9 4.03 9 9">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.2s" values="16;0"/>
                    <animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/>
                </path>
            </svg>
        </div>
        {{-- END : LOADER --}}
        {{--  --}}
        <div class="w-full flex">
            {{-- LEFT SIDEBAR --}}
            <div>
                @include('partials.sidebar')
                <div x-show="sidebarOpen" x-on:click="sidebarOpen = false" class="w-full h-screen lg:hidden fixed inset-0 z-20 bg-black-primary bg-opacity-20 backdrop-blur-2xl"></div>
            </div>
            {{-- RIGHT CONTENT --}}
            <section class="w-full min-h-screen bg-pink-addfirst">
                {{-- TOP NAVBAR --}}
                @include('partials.navbar')
                {{-- CONTENT --}}
                <div class="w-full max-w-7xl mx-auto p-3 lg:p-5 lg:pt-10">
                    @yield('content')
                </div>
            </section>
        </div>
        
        @include('sweetalert::alert')
        @stack('script')
    </body>
</html>
