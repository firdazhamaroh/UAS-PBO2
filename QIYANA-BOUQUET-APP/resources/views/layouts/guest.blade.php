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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="w-full max-w-[1700px] mx-auto h-screen flex justify-center items-center">
            {{-- LEFT --}}
            <div class="relative w-full h-full md:w-1/2 hidden lg:flex justify-center items-center bg-pink-secondary">
                <div class="w-full h-full absolute inset-0 z-10 bg-black-primary bg-opacity-40"></div>
                <img src="{{ asset('images/login.png') }}" alt="Bunga" class="w-full h-full object-cover" />
            </div>
            {{-- RIGHT --}}
            <div class="w-full h-full md:w-1/2 flex justify-center items-center bg-white">
                @yield('content')
            </div>
        </div>
    </body>
</html>
