<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Qiyana Bouquet - Toko Buket Bunga Terbaik di Kabupaten Pekalongan</title>
        {{--  --}}
        <meta name="robots" content="index, follow">
        <meta name="description" content="Qiyana Bouquet">
        
        <meta property="og:title" content="Qiyana Bouquet" />
        <meta property="og:description" content="Toko Buket bunga terbaik di Kabupaten Pekalongan" />
        <meta property="og:image" content="{{ asset('images/og.png') }}" />
        <meta property="og:url" content="https://qiyanabouquet.cepet.cloud" />
        <meta property="og:type" content="website" />

        <meta name="twitter:card" content="{{ asset('images/og.png') }}">
        <meta name="twitter:title" content="Qiyana Bouquet">
        <meta name="twitter:description" content="Toko Buket bunga terbaik di Kabupaten Pekalongan">
        <meta name="twitter:image" content="{{ asset('images/og.png') }}">
        {{-- GOOGLE FONTS --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
        {{-- IKON --}}
        <script src="https://code.iconify.design/iconify-icon/1.0.5/iconify-icon.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body :class="productModalOpen != 0 ? 'overflow-y-hidden' : ''" x-cloak x-data="{ loaded: true, productModalOpen: {{ $errors->any() ? old('product_id') : 0 }}, productDetail: [], customerType: '{{ old('customer_type') == 'old_cust' ? 'oldCust' : 'newCust' }}', orderType: '', quantities: 1 }" class="homepage">
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

        {{-- START : PRODUCT MODAL --}}
        <div x-show="productModalOpen" class="w-full h-screen fixed z-50 inset-0 flex justify-center items-center bg-black-primary bg-opacity-50 backdrop-blur-2xl px-4">
            <div x-on:click.outside="productModalOpen = 0" class="w-full max-w-screen-xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-5 bg-white rounded-lg lg:rounded-2xl overflow-hidden my-20">
                {{-- LEFT --}}
                <div class="w-full h-full hidden lg:flex">
                    <img src="{{ asset('images/checkout.jpg') }}" alt="Checkout representation" class="w-full h-full object-cover" />
                </div>
                {{-- RIGHT --}}
                <div class="w-full h-[700px] max-h-[700px] overflow-y-auto py-20 px-4">
                    {{-- FORM WRAPPER --}}
                    <div class="w-full max-w-md mx-auto">
                        <h1 class="text-xl md:text-2xl font-bold">🛒 Checkout</h1>
                        <div class="space-y-1 pt-16">
                            <h1 class="text-xl md:text-2xl font-bold" x-text="productDetail['product_name']"></h1>
                            <p class="text-sm">Beli item ini</p>
                        </div>
                        <div class="w-full flex items-center space-x-2 py-3">
                            <button x-on:click.prevent="quantities = Math.max(1, quantities - 1)" class="min-w-7 h-7 flex justify-center items-center bg-gray-200 hover:bg-gray-300 rounded-full">-</button>
                            <input type="text" id="qty" name="qty" x-model="quantities" min="1" class="w-full h-10 text-sm text-center border-gray-300 focus:border-green-custom rounded-md focus:ring-1 focus:ring-offset-1 focus:ring-green-custom" />
                            <button x-on:click.prevent="quantities++" class="min-w-7 h-7 flex justify-center items-center bg-gray-200 hover:bg-gray-300 rounded-full">+</button>
                        </div>
                        <p x-show="quantities < 1" class="text-center text-red-500 text-sm">Pembelian minimal adalah 1</p>
                        {{-- TABS --}}
                        <div class="w-full grid grid-cols-2 mt-5">
                            {{-- LEFT --}}
                            <button x-on:click="customerType = 'newCust'" :class="customerType == 'newCust' ? 'bg-pink-primary text-white font-semibold' : 'bg-gray-300 text-black-primary'" class="w-full flex justify-center items-center text-xs md:text-sm rounded-l-md py-3">Pelanggan baru</button>
                            {{-- RIGHT --}}
                            <button x-on:click="customerType = 'oldCust'" :class="customerType == 'oldCust' ? 'bg-pink-primary text-white font-semibold' : 'bg-gray-300 text-black-primary'" class="w-full flex justify-center items-center text-xs md:text-sm rounded-r-md py-3">Sudah pernah beli</button>
                        </div>
                        {{-- NEW CUSTOMER --}}
                        <form x-show="customerType == 'newCust'" method="POST" action="{{ route('frontend.store-order') }}" class="space-y-6 py-5">
                            @csrf
                            <input type="hidden" name="order_type" x-model="orderType" />
                            <input type="hidden" name="customer_type" value="new_cust" />
                            <input type="hidden" name="product_id" :value="`{{ old('product_id') ?? '' }}` || productDetail.product_id" />
                            <input type="hidden" name="qty" :value="quantities" />
                            {{-- SINGLE INPUT : NAME --}}
                            <div id="input-group">
                                <x-input-label for="full_name" :value="__('Nama Lengkap')" />
                                <div class="relative">
                                    <div class="absolute top-1/2 left-0 transform -translate-y-1/2 z-10 ml-4 mt-0.5">
                                        <iconify-icon icon="solar:user-broken" width="20" height="20"></iconify-icon>
                                    </div>
                                    <x-text-input id="full_name" class="w-full placeholder-gray-400 pl-12 pr-4 py-3" type="text" name="full_name" :value="old('full_name')" placeholder="Nama lengkap Anda" />
                                </div>
                                <x-input-error id="input-error" :messages="$errors->get('full_name')" class="mt-2" />
                            </div>
                            {{-- SINGLE INPUT : EMAIL --}}
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
                            {{-- SINGLE INPUT : WHATSAPP --}}
                            <div id="input-group">
                                <x-input-label for="whatsapp" :value="__('Nomor WhatsApp')" />
                                <div class="relative">
                                    <div class="absolute top-1/2 left-0 transform -translate-y-1/2 z-10 ml-5 mt-0.5">
                                        <iconify-icon icon="ic:outline-whatsapp" width="20" height="20"></iconify-icon>
                                    </div>
                                    <x-text-input id="whatsapp" class="w-full placeholder-gray-400 pl-12 pr-4 py-3" type="text" name="whatsapp" :value="old('whatsapp')" placeholder="Masukkan whatsapp Anda"  />
                                </div>
                                <x-input-error id="input-error" :messages="$errors->get('whatsapp')" class="mt-2" />
                            </div>
                            {{-- SINGLE INPUT : ADDRESS --}}
                            <div id="input-group">
                                <x-input-label for="address" :value="__('Alamat Lengkap')" />
                                <div class="relative">
                                    <div class="absolute top-3 left-0 transform z-10 ml-5 mt-0.5">
                                        <iconify-icon icon="f7:placemark" width="20" height="20"></iconify-icon>
                                    </div>
                                    <textarea name="address" id="address" rows="4" placeholder="Alamat lengkap Anda" class="w-full placeholder-gray-400 text-sm transition-all duration-300 border-gray-300 focus:border-pink-primary ring-transparent focus:ring-transparent rounded-lg pl-12 pr-4 py-3">{{ old('address') }}</textarea>
                                </div>
                                <x-input-error id="input-error" :messages="$errors->get('address')" class="mt-2" />
                            </div>
                            {{--  --}}
                            <div class="w-full grid grid-cols-1 lg:grid-cols-3">
                                <button x-on:click.prevent="orderType = 'cod'" :class="orderType == 'cod' ? 'bg-pink-primary text-white' : ''" class="w-full flex justify-center items-center text-sm border py-3 rounded-t-lg lg:rounded-r-none lg:rounded-l-lg">COD</button>
                                <button x-on:click.prevent="orderType = 'ambil'" :class="orderType == 'ambil' ? 'bg-pink-primary text-white' : ''" class="w-full flex justify-center items-center text-sm border py-3">Ambil Di QiyanaBouquet</button>
                                <button x-on:click.prevent="orderType = 'diantar'" :class="orderType == 'diantar' ? 'bg-pink-primary text-white' : ''" class="w-full flex justify-center items-center text-sm border py-3 rounded-b-lg lg:rounded-l-none lg:rounded-r-lg">Diantar</button>
                                <x-input-error id="input-error" :messages="$errors->get('order_type')" class="col-span-3 mt-2" />
                            </div>
                            {{-- INPUT COD --}}
                            <div x-show="orderType == 'cod'" class="w-full">
                                {{-- INPUT COD --}}
                                <div id="input-group">
                                    <x-input-label for="cod_address" :value="__('Masukkan Lokasi COD')" />
                                    <div class="relative">
                                        <div class="absolute top-3 left-0 transform z-10 ml-5 mt-0.5">
                                            <iconify-icon icon="f7:placemark" width="20" height="20"></iconify-icon>
                                        </div>
                                        <textarea name="cod_address" id="cod_address" rows="4" placeholder="Dimana Anda ingin melakukan COD" class="w-full placeholder-gray-400 text-sm transition-all duration-300 border-gray-300 focus:border-pink-primary ring-transparent focus:ring-transparent rounded-lg pl-12 pr-4 py-3">{{ old('cod_address') }}</textarea>
                                    </div>
                                    <x-input-error id="input-error" :messages="$errors->get('cod_address')" class="mt-2" />
                                </div>
                            </div>
                            {{-- ALAMAT QIYANABOUQUET --}}
                            <div x-show="orderType == 'ambil'" class="w-full">
                                {{-- INPUT COD --}}
                                <div x-data="{ textToCopy: 'https://maps.app.goo.gl/Znjx7Ua22jekLUdS7?g_st=awb', successCopy: false, copy() { navigator.clipboard.writeText(this.textToCopy).then(() => { this.successCopy = true; setTimeout(() => {this.successCopy = false}, 2000) }) } }" class="w-full bg-pink-primary bg-opacity-20 text-pink-primary border border-pink-primary/50 rounded-lg p-3">
                                    <h1 class="font-bold text-gray-700 py-2">Ambil di QiyanaBouquet</h1>
                                    <p class="text-sm">Dukuh purwosari no.3, RT01 RW01, Ds. Gandarum, Kec. Kajen, Kabupaten Pekalongan</p>
                                    <div class="py-3">
                                        <input disabled type="text" x-model="textToCopy" :class="successCopy ? 'border-blue-500 disabled:bg-blue-500/30 text-blue-600' : 'border-pink-primary/50 disabled:bg-pink-primary/20'" class="w-full text-sm border rounded-md p-2" />
                                        <p x-show="successCopy" class="text-xs text-center mt-1">Link berhasil disalin!</p>
                                    </div>
                                    <button x-on:click.prevent="copy" class="flex items-center space-x-1 text-blue-500 hover:text-blue-600 mt-2">
                                        <iconify-icon icon="solar:copy-outline" width="16" height="16"></iconify-icon>
                                        <span class="text-sm">Copy link maps</span>
                                    </button>
                                </div>
                            </div>
                            {{-- DIANTAR --}}
                            <div x-show="orderType == 'diantar'" class="w-full">
                                {{-- INPUT COD --}}
                                <div class="w-full bg-pink-primary bg-opacity-20 text-pink-primary border border-pink-primary/70 rounded-lg p-3">
                                    <h1 class="font-bold text-gray-700 py-2">Diantar</h1>
                                    <p class="text-sm">Admin akan mengantar ke alamat yang Anda masukkan</p>
                                </div>
                            </div>
                            {{-- BUTTON --}}
                            <div class="flex mt-4">
                                <div class="w-full relative rounded-full">
                                    <x-primary-button type="submit" class="w-full">Beli Sekarang</x-primary-button>
                                </div>
                            </div>
                        </form>
                        {{-- OLD CUSTOMER --}}
                        <form x-show="customerType == 'oldCust'" method="POST" action="{{ route('frontend.store-order') }}" class="space-y-6 py-5">
                            @csrf
                            <input type="hidden" name="order_type" x-model="orderType" />
                            <input type="hidden" name="customer_type" value="old_cust" />
                            <input type="hidden" name="product_id" :value="`{{ old('product_id') ?? '' }}` || productDetail.product_id" />
                            <input type="hidden" name="qty" :value="quantities" />
                            {{-- SINGLE INPUT : WHATSAPP --}}
                            <div id="input-group">
                                <x-input-label for="old_whatsapp" :value="__('Nomor WhatsApp')" />
                                <div class="relative">
                                    <div class="absolute top-1/2 left-0 transform -translate-y-1/2 z-10 ml-5 mt-0.5">
                                        <iconify-icon icon="ic:outline-whatsapp" width="20" height="20"></iconify-icon>
                                    </div>
                                    <x-text-input id="old_whatsapp" class="w-full placeholder-gray-400 pl-12 pr-4 py-3" type="text" name="old_whatsapp" :value="old('old_whatsapp')" placeholder="Masukkan whatsapp Anda"  />
                                </div>
                                <x-input-error id="input-error" :messages="$errors->get('old_whatsapp')" class="mt-2" />
                            </div>
                            {{--  --}}
                            <div class="w-full grid grid-cols-1 lg:grid-cols-3">
                                <button x-on:click.prevent="orderType = 'cod'" :class="orderType == 'cod' ? 'bg-pink-primary text-white' : ''" class="w-full flex justify-center items-center text-sm border py-3 rounded-t-lg lg:rounded-r-none lg:rounded-l-lg">COD</button>
                                <button x-on:click.prevent="orderType = 'ambil'" :class="orderType == 'ambil' ? 'bg-pink-primary text-white' : ''" class="w-full flex justify-center items-center text-sm border py-3">Ambil Di QiyanaBouquet</button>
                                <button x-on:click.prevent="orderType = 'diantar'" :class="orderType == 'diantar' ? 'bg-pink-primary text-white' : ''" class="w-full flex justify-center items-center text-sm border py-3 rounded-b-lg lg:rounded-l-none lg:rounded-r-lg">Diantar</button>
                                <x-input-error id="input-error" :messages="$errors->get('order_type')" class="col-span-3 mt-2" />
                            </div>
                            {{-- INPUT COD --}}
                            <div x-show="orderType == 'cod'" class="w-full">
                                <div id="input-group">
                                    <x-input-label for="cod_address" :value="__('Masukkan Lokasi COD')" />
                                    <div class="relative">
                                        <div class="absolute top-3 left-0 transform z-10 ml-5 mt-0.5">
                                            <iconify-icon icon="f7:placemark" width="20" height="20"></iconify-icon>
                                        </div>
                                        <textarea name="cod_address" id="cod_address" rows="4" placeholder="Dimana Anda ingin melakukan COD" class="w-full placeholder-gray-400 text-sm transition-all duration-300 border-gray-300 focus:border-pink-primary ring-transparent focus:ring-transparent rounded-lg pl-12 pr-4 py-3">{{ old('cod_address') }}</textarea>
                                    </div>
                                    <x-input-error id="input-error" :messages="$errors->get('cod_address')" class="mt-2" />
                                </div>
                            </div>
                            {{-- ALAMAT QIYANABOUQUET --}}
                            <div x-show="orderType == 'ambil'" class="w-full">
                                {{-- INPUT COD --}}
                                <div x-data="{ textToCopy: 'https://maps.app.goo.gl/Znjx7Ua22jekLUdS7?g_st=awb', successCopy: false, copy() { navigator.clipboard.writeText(this.textToCopy).then(() => { this.successCopy = true; setTimeout(() => {this.successCopy = false}, 2000) }) } }" class="w-full bg-pink-primary bg-opacity-20 text-pink-primary border border-pink-primary/50 rounded-lg p-3">
                                    <h1 class="font-bold text-gray-700 py-2">Ambil di QiyanaBouquet</h1>
                                    <p class="text-sm">Dukuh purwosari no.3, RT01 RW01, Ds. Gandarum, Kec. Kajen, Kabupaten Pekalongan</p>
                                    <div class="py-3">
                                        <input disabled type="text" x-model="textToCopy" :class="successCopy ? 'border-blue-500 disabled:bg-blue-500/30 text-blue-600' : 'border-pink-primary/50 disabled:bg-pink-primary/20'" class="w-full text-sm border rounded-md p-2" />
                                        <p x-show="successCopy" class="text-xs text-center mt-1">Link berhasil disalin!</p>
                                    </div>
                                    <button x-on:click.prevent="copy" class="flex items-center space-x-1 text-blue-500 hover:text-blue-600 mt-2">
                                        <iconify-icon icon="solar:copy-outline" width="16" height="16"></iconify-icon>
                                        <span class="text-sm">Copy link maps</span>
                                    </button>
                                </div>
                            </div>
                            {{-- DIANTAR --}}
                            <div x-show="orderType == 'diantar'" class="w-full">
                                {{-- INPUT COD --}}
                                <div class="w-full bg-pink-primary bg-opacity-20 text-pink-primary border border-pink-primary/70 rounded-lg p-3">
                                    <h1 class="font-bold text-gray-700 py-2">Diantar</h1>
                                    <p class="text-sm">Admin akan mengantar ke alamat yang Anda masukkan</p>
                                </div>
                            </div>
                            {{-- BUTTON --}}
                            <div class="flex mt-4">
                                <div class="w-full relative rounded-full">
                                    <x-primary-button type="submit" class="w-full">Beli Sekarang</x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- END : PRODUCT MODAL --}}

        {{-- START : HEADER --}}
        <header class="w-full bg-pink-addfirst pb-10 md:py-44">
            {{-- START : NAVBAR --}}
            <nav id="main-navbar" x-cloak x-data="{ navbarOpen: false }" class="w-full flex justify-center items-center fixed z-40 top-0 left-1/2 transform -translate-x-1/2 transition-all duration-300 px-4 md:px-10 xl:px-5">
                <div class="w-full max-w-screen-xl mx-auto flex justify-between py-3 md:py-5">
                    {{-- LEFT : LOGO --}}
                    <a href="{{ route('frontend.index') }}" class="w-20 md:w-24 h-full flex justify-center items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="" class="w-full" />
                    </a>
                    {{-- MENU --}}
                    <div x-on:click="navbarOpen = false" :class="navbarOpen ? 'flex' : 'hidden'" class="w-full h-screen lg:hidden fixed z-10 top-0 left-0 bg-black-primary bg-opacity-20 backdrop-blur-2xl"></div>
                    <ul :class="navbarOpen ? 'translate-x-0' : '-translate-x-full'" class="w-full lg:w-auto h-screen lg:h-auto fixed z-20 top-0 left-0 lg:relative flex flex-col space-y-10 lg:space-y-0 lg:space-x-10 lg:flex-row justify-center lg:justify-start items-center transition-all duration-300 bg-white lg:bg-transparent shadow-2xl lg:shadow-none transform lg:transform-none">
                        <li class="text-base">
                            <button class="nav-link hover:text-pink-primary" id="about">Tentang Kami</button>
                        </li>
                        <li class="text-base">
                            <button class="nav-link hover:text-pink-primary" id="katalog">Katalog</button>
                        </li>
                        <li>
                            <a href="https://wa.me/6285803685203">
                                <x-primary-button class="w-44">Hubungi Kami</x-primary-button>
                            </a>
                        </li>
                        <li class="lg:hidden">
                            <button x-on:click="navbarOpen = false" class="w-12 h-12 flex justify-center items-center border rounded-full text-gray-500 transition-all duration-300 hover:bg-gray-100">
                                <iconify-icon icon="clarity:times-line" width="24" height="24"></iconify-icon>
                            </button>
                        </li>
                    </ul>
                    {{-- RIGHT : MENU --}}
                    <div class="flex lg:hidden">
                        <button x-on:click="navbarOpen = !navbarOpen" class="inline-flex items-center justify-center rounded-md text-gray-400 hover:text-gray-500 hover:bg-pink-secondary focus:outline-none focus:bg-pink-primary focus:text-gray-500 transition duration-150 ease-in-out px-4 py-2">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>
            {{-- END : NAVBAR --}}
            {{-- START : JUMBOTROON --}}
            <div class="w-full max-w-screen-xl mx-auto h-full grid grid-cols-1 lg:grid-cols-2 gap-5">
                {{-- LEFT --}}
                <div class="w-full h-full flex flex-col justify-center space-y-3 p-4 pt-40 md:p-10 xl:p-0">
                    <h1 class="text-3xl md:text-4xl lg:text-6xl font-bold lg:leading-[1.2]">Kirim Bunga Terbaik untuk Orang Tersayang</h1>
                    <p class="leading-loose">Sempurnakan momen bahagia Anda dengan <span class="font-semibold">Buket Bunga</span> dari <span class="text-pink-primary">Qiyana Bouquet</span>, kami menjamin kualitas buket bunga terbaik untuk Anda</p>
                    <div class="w-full flex items-center space-x-3 pt-3">
                        <a href="" class="w-full sm:w-44">
                            <x-primary-button class="w-full sm:w-44">Jelajahi Katalog</x-primary-button>
                        </a>
                    </div>
                </div>
                {{-- RIGHT --}}
                <div class="w-full h-full flex justify-center lg:justify-end items-center">
                    <img src="{{ asset('images/homepage-header-right-image.png') }}" alt="" class="w-full max-w-xl" />
                </div>
            </div>
            {{-- END : JUMBOTROON --}}
        </header>
        {{-- END : HEADER --}}
        {{-- START : COUNT --}}
        <section class="w-full bg-pink-secondary py-20">
            <div class="w-full max-w-screen-xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-y-14 md:gap-5 px-4 md:px-10 xl:px-5">
                {{-- SINGLE ITEM --}}
                <div class="w-full flex flex-col items-center">
                    <h1 class="text-3xl md:text-4xl font-bold">100%</h1>
                    <p>Kepuasan Pelanggan</p>
                </div>
                {{-- SINGLE ITEM --}}
                <div class="w-full flex flex-col items-center">
                    <h1 class="text-3xl md:text-4xl font-bold">{{ $soldProduct}}+</h1>
                    <p>Produk Terjual</p>
                </div>
                {{-- SINGLE ITEM --}}
                <div class="w-full flex flex-col items-center">
                    <h1 class="text-3xl md:text-4xl font-bold">{{ $customer }}+</h1>
                    <p>Total Pelanggan</p>
                </div>
            </div>
        </section>
        {{-- END : COUNT --}}
        {{-- START : BEST SELLER --}}
        <section class="w-full bg-pink-addfirst py-20">
            {{-- TOP TITLE --}}
            <div class="w-full max-w-screen-xl mx-auto px-4 md:px-10 xl:px-5">
                <p>Best Seller</p>
                <h1 class="text-3xl md:text-4xl font-bold">Produk Best Seller Bulan Ini</h1>
            </div>
            {{-- PRODUCTS --}}
            <div class="w-full max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 px-4 md:px-10 xl:px-5 pt-20">
                {{-- SINGLE PRODUCT --}}
                @forelse ($products as $product)
                    <div x-on:click="
                        productModalOpen = {{ $product->id }}, 
                        productDetail['product_name'] = '{{ $product->product_name }}',
                        productDetail['product_id'] = '{{ $product->id }}'
                        " class="group hover:cursor-pointer">
                        <div class="relative">
                            <div class="absolute top-5 left-0 -ml-2">
                                <svg width="60" height="29" viewBox="0 0 60 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M53.0068 14.5L59.3676 23.2C60.3688 24.581 60.178 25.8929 58.7951 27.1357C57.4122 28.3786 55.4533 29 52.9184 29L7.06757 29C5.12399 29 3.46075 28.594 2.07786 27.782C0.694977 26.97 0.00235572 25.995 -1.8109e-07 24.8571L-1.08654e-06 4.14286C-1.13634e-06 3.00358 0.692621 2.02793 2.07786 1.21593C3.46311 0.403934 5.12634 -0.00137352 7.06757 7.32046e-06L52.9184 5.31626e-06C55.451 5.20556e-06 57.4098 0.621433 58.7951 1.86429C60.1803 3.10715 60.3712 4.41905 59.3676 5.8L53.0068 14.5Z" fill="#262626"/>
                                    <path d="M10.4641 19V7.8H14.8481C15.6375 7.8 16.2935 7.92267 16.8161 8.168C17.3495 8.41333 17.7495 8.75467 18.0161 9.192C18.2828 9.61867 18.4161 10.1147 18.4161 10.68C18.4161 11.2453 18.2935 11.72 18.0481 12.104C17.8028 12.488 17.4775 12.7813 17.0721 12.984C16.6775 13.1867 16.2455 13.3093 15.7761 13.352L16.0161 13.176C16.5175 13.1867 16.9655 13.32 17.3601 13.576C17.7655 13.832 18.0855 14.168 18.3201 14.584C18.5548 14.9893 18.6721 15.4427 18.6721 15.944C18.6721 16.5307 18.5281 17.0587 18.2401 17.528C17.9628 17.9867 17.5521 18.3493 17.0081 18.616C16.4641 18.872 15.7975 19 15.0081 19H10.4641ZM12.3841 17.432H14.7201C15.3495 17.432 15.8401 17.2827 16.1921 16.984C16.5441 16.6853 16.7201 16.2693 16.7201 15.736C16.7201 15.2027 16.5388 14.7813 16.1761 14.472C15.8135 14.152 15.3175 13.992 14.6881 13.992H12.3841V17.432ZM12.3841 12.536H14.5761C15.1948 12.536 15.6641 12.3973 15.9841 12.12C16.3041 11.832 16.4641 11.4373 16.4641 10.936C16.4641 10.4453 16.3041 10.0613 15.9841 9.784C15.6641 9.496 15.1895 9.352 14.5601 9.352H12.3841V12.536ZM24.223 19.192C23.423 19.192 22.719 19.0213 22.111 18.68C21.503 18.328 21.0283 17.8373 20.687 17.208C20.3457 16.5787 20.175 15.8533 20.175 15.032C20.175 14.1787 20.3403 13.432 20.671 12.792C21.0123 12.152 21.487 11.6507 22.095 11.288C22.7137 10.9253 23.4283 10.744 24.239 10.744C25.0283 10.744 25.7163 10.92 26.303 11.272C26.8897 11.624 27.343 12.0987 27.663 12.696C27.983 13.2827 28.143 13.944 28.143 14.68C28.143 14.7867 28.143 14.904 28.143 15.032C28.143 15.16 28.1323 15.2933 28.111 15.432H21.551V14.2H26.207C26.1857 13.6133 25.9883 13.1547 25.615 12.824C25.2417 12.4827 24.7777 12.312 24.223 12.312C23.8283 12.312 23.4657 12.4027 23.135 12.584C22.8043 12.7653 22.543 13.0373 22.351 13.4C22.159 13.752 22.063 14.2 22.063 14.744V15.208C22.063 15.7093 22.1537 16.1413 22.335 16.504C22.527 16.8667 22.783 17.144 23.103 17.336C23.4337 17.5173 23.8017 17.608 24.207 17.608C24.655 17.608 25.023 17.512 25.311 17.32C25.6097 17.128 25.8283 16.872 25.967 16.552H27.919C27.7697 17.0533 27.5243 17.5067 27.183 17.912C26.8417 18.3067 26.4203 18.6213 25.919 18.856C25.4177 19.08 24.8523 19.192 24.223 19.192ZM33.1318 19.192C32.4171 19.192 31.7931 19.08 31.2598 18.856C30.7371 18.6213 30.3211 18.3013 30.0118 17.896C29.7131 17.48 29.5371 17.0053 29.4838 16.472H31.4038C31.4571 16.696 31.5531 16.904 31.6918 17.096C31.8304 17.2773 32.0171 17.4213 32.2518 17.528C32.4971 17.6347 32.7851 17.688 33.1158 17.688C33.4358 17.688 33.6971 17.6453 33.8998 17.56C34.1024 17.464 34.2518 17.3413 34.3478 17.192C34.4438 17.0427 34.4918 16.8827 34.4918 16.712C34.4918 16.456 34.4224 16.2587 34.2838 16.12C34.1451 15.9813 33.9424 15.8747 33.6758 15.8C33.4198 15.7147 33.1104 15.6347 32.7478 15.56C32.3638 15.4853 31.9904 15.3947 31.6278 15.288C31.2758 15.1707 30.9558 15.0267 30.6678 14.856C30.3904 14.6853 30.1664 14.4667 29.9958 14.2C29.8358 13.9333 29.7558 13.608 29.7558 13.224C29.7558 12.7547 29.8784 12.3333 30.1238 11.96C30.3798 11.5867 30.7424 11.2933 31.2118 11.08C31.6918 10.856 32.2624 10.744 32.9238 10.744C33.8624 10.744 34.6091 10.9627 35.1638 11.4C35.7291 11.8267 36.0598 12.4293 36.1558 13.208H34.3318C34.2784 12.9093 34.1291 12.68 33.8838 12.52C33.6384 12.3493 33.3131 12.264 32.9078 12.264C32.4918 12.264 32.1718 12.344 31.9478 12.504C31.7344 12.6533 31.6278 12.856 31.6278 13.112C31.6278 13.272 31.6918 13.4213 31.8198 13.56C31.9584 13.688 32.1558 13.8 32.4118 13.896C32.6678 13.9813 32.9824 14.0667 33.3558 14.152C33.9531 14.2693 34.4811 14.408 34.9398 14.568C35.3984 14.728 35.7611 14.9627 36.0278 15.272C36.2944 15.5813 36.4278 16.0187 36.4278 16.584C36.4384 17.096 36.3051 17.5493 36.0278 17.944C35.7611 18.3387 35.3824 18.648 34.8918 18.872C34.4011 19.0853 33.8144 19.192 33.1318 19.192ZM41.5135 19C40.9695 19 40.4948 18.9147 40.0895 18.744C39.6948 18.5733 39.3855 18.2907 39.1615 17.896C38.9375 17.5013 38.8255 16.968 38.8255 16.296V12.552H37.4495V10.936H38.8255L39.0495 8.808H40.7455V10.936H42.9375V12.552H40.7455V16.296C40.7455 16.7013 40.8308 16.984 41.0015 17.144C41.1828 17.2933 41.4815 17.368 41.8975 17.368H42.8895V19H41.5135Z" fill="white"/>
                                </svg>
                            </div>
                            <div class="w-full h-80 bg-pink-secondary rounded-t-2xl overflow-hidden">
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="" class="w-full h-full object-cover transition-all duration-300 transform group-hover:scale-110" />
                            </div>
                        </div>
                        <div class="w-full bg-white rounded-b-2xl p-5">
                            <span>{{ $product->product_category->name }}</span>
                            <h1 class="text-lg font-bold group-hover:text-pink-primary">{{ $product->product_name }}</h1>
                            <span class="text-pink-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="w-full md:grid-cols-2 lg:grid-cols-4">
                        <h1>Belum ada produk terdaftar</h1>
                    </div>
                @endforelse
            </div>
        </section>
        {{-- END : BEST SELLER --}}
        {{-- START : WHY --}}
        <section id="about-section" class="w-full bg-pink-addfirst pb-10 pt-32 md:py-44">
            {{-- START : WHY QIYANA BOUQUET --}}
            <div class="w-full max-w-screen-xl mx-auto h-full grid grid-cols-1 lg:grid-cols-2 gap-5">
                {{-- RIGHT --}}
                <div class="w-full h-full flex justify-center lg:justify-start items-center">
                    <img src="{{ asset('images/why-qiyana-bouquet.png') }}" alt="" class="w-full max-w-xl" />
                </div>
                {{-- LEFT --}}
                <div class="w-full h-full flex flex-col justify-center space-y-3 p-4 pt-20 md:p-10">
                    <h1 class="text-3xl md:text-4xl lg:text-6xl font-bold lg:leading-[1.2]">Kenapa Harus Qiyana Bouquet?</h1>
                    <p class="leading-loose">Qiyana Bouquet adalah pilihan terbaik untuk Anda yang ingin memberikan kesan istimewa melalui bunga. Kami menghadirkan rangkaian bunga, dan berbagai macam buket berkualitas dengan desain yang elegan dan penuh makna. Setiap buket dirangkai dengan cinta oleh florist berpengalaman untuk berbagai momen spesial Anda.</p>
                    <ul class="w-full flex flex-col space-y-3 pt-3">
                        {{-- SINGLE ITEM --}}
                        <li class="flex items-center space-x-3">
                            <img src="{{ asset('icons/check.svg') }}" alt="" />
                            <span>Pelayanan Terbaik Terhadap Pelanggan</span>
                        </li>
                        {{-- SINGLE ITEM --}}
                        <li class="flex items-center space-x-3">
                            <img src="{{ asset('icons/check.svg') }}" alt="" />
                            <span>Kualitas Buket Terjamin</span>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- END : WHY QIYANA BOUQUET --}}
        </section>
        {{-- END : WHY --}}
        {{-- START : OUR CATALOG --}}
        <section id="katalog-section" class="w-full bg-pink-secondary py-20 lg:py-44">
            {{-- TOP TITLE --}}
            <div class="w-full max-w-2xl mx-auto text-center space-y-3 px-4 md:px-10 xl:px-5">
                <h1 class="text-3xl md:text-4xl font-bold">Jelajahi Katalog Kami</h1>
                <p>Jelajahi dan temukan koleksi buket bunga kami yang dirangkai dengan cinta dan penuh makna untuk setiap momen spesial dalam hidup Anda</p>
            </div>
            {{-- PRODUCTS --}}
            <div class="w-full max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 px-4 md:px-10 xl:px-5 pt-20">
                {{-- SINGLE PRODUCT --}}
                @forelse ($allProducts as $product)
                    <div x-on:click="
                        productModalOpen = {{ $product->id }}, 
                        productDetail['product_name'] = '{{ $product->product_name }}',
                        productDetail['product_id'] = '{{ $product->id }}'
                        " class="group hover:cursor-pointer">
                        <div class="relative">
                            <div class="absolute top-5 left-0 -ml-2">
                                <svg width="60" height="29" viewBox="0 0 60 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M53.0068 14.5L59.3676 23.2C60.3688 24.581 60.178 25.8929 58.7951 27.1357C57.4122 28.3786 55.4533 29 52.9184 29L7.06757 29C5.12399 29 3.46075 28.594 2.07786 27.782C0.694977 26.97 0.00235572 25.995 -1.8109e-07 24.8571L-1.08654e-06 4.14286C-1.13634e-06 3.00358 0.692621 2.02793 2.07786 1.21593C3.46311 0.403934 5.12634 -0.00137352 7.06757 7.32046e-06L52.9184 5.31626e-06C55.451 5.20556e-06 57.4098 0.621433 58.7951 1.86429C60.1803 3.10715 60.3712 4.41905 59.3676 5.8L53.0068 14.5Z" fill="#262626"/>
                                    <path d="M10.4641 19V7.8H14.8481C15.6375 7.8 16.2935 7.92267 16.8161 8.168C17.3495 8.41333 17.7495 8.75467 18.0161 9.192C18.2828 9.61867 18.4161 10.1147 18.4161 10.68C18.4161 11.2453 18.2935 11.72 18.0481 12.104C17.8028 12.488 17.4775 12.7813 17.0721 12.984C16.6775 13.1867 16.2455 13.3093 15.7761 13.352L16.0161 13.176C16.5175 13.1867 16.9655 13.32 17.3601 13.576C17.7655 13.832 18.0855 14.168 18.3201 14.584C18.5548 14.9893 18.6721 15.4427 18.6721 15.944C18.6721 16.5307 18.5281 17.0587 18.2401 17.528C17.9628 17.9867 17.5521 18.3493 17.0081 18.616C16.4641 18.872 15.7975 19 15.0081 19H10.4641ZM12.3841 17.432H14.7201C15.3495 17.432 15.8401 17.2827 16.1921 16.984C16.5441 16.6853 16.7201 16.2693 16.7201 15.736C16.7201 15.2027 16.5388 14.7813 16.1761 14.472C15.8135 14.152 15.3175 13.992 14.6881 13.992H12.3841V17.432ZM12.3841 12.536H14.5761C15.1948 12.536 15.6641 12.3973 15.9841 12.12C16.3041 11.832 16.4641 11.4373 16.4641 10.936C16.4641 10.4453 16.3041 10.0613 15.9841 9.784C15.6641 9.496 15.1895 9.352 14.5601 9.352H12.3841V12.536ZM24.223 19.192C23.423 19.192 22.719 19.0213 22.111 18.68C21.503 18.328 21.0283 17.8373 20.687 17.208C20.3457 16.5787 20.175 15.8533 20.175 15.032C20.175 14.1787 20.3403 13.432 20.671 12.792C21.0123 12.152 21.487 11.6507 22.095 11.288C22.7137 10.9253 23.4283 10.744 24.239 10.744C25.0283 10.744 25.7163 10.92 26.303 11.272C26.8897 11.624 27.343 12.0987 27.663 12.696C27.983 13.2827 28.143 13.944 28.143 14.68C28.143 14.7867 28.143 14.904 28.143 15.032C28.143 15.16 28.1323 15.2933 28.111 15.432H21.551V14.2H26.207C26.1857 13.6133 25.9883 13.1547 25.615 12.824C25.2417 12.4827 24.7777 12.312 24.223 12.312C23.8283 12.312 23.4657 12.4027 23.135 12.584C22.8043 12.7653 22.543 13.0373 22.351 13.4C22.159 13.752 22.063 14.2 22.063 14.744V15.208C22.063 15.7093 22.1537 16.1413 22.335 16.504C22.527 16.8667 22.783 17.144 23.103 17.336C23.4337 17.5173 23.8017 17.608 24.207 17.608C24.655 17.608 25.023 17.512 25.311 17.32C25.6097 17.128 25.8283 16.872 25.967 16.552H27.919C27.7697 17.0533 27.5243 17.5067 27.183 17.912C26.8417 18.3067 26.4203 18.6213 25.919 18.856C25.4177 19.08 24.8523 19.192 24.223 19.192ZM33.1318 19.192C32.4171 19.192 31.7931 19.08 31.2598 18.856C30.7371 18.6213 30.3211 18.3013 30.0118 17.896C29.7131 17.48 29.5371 17.0053 29.4838 16.472H31.4038C31.4571 16.696 31.5531 16.904 31.6918 17.096C31.8304 17.2773 32.0171 17.4213 32.2518 17.528C32.4971 17.6347 32.7851 17.688 33.1158 17.688C33.4358 17.688 33.6971 17.6453 33.8998 17.56C34.1024 17.464 34.2518 17.3413 34.3478 17.192C34.4438 17.0427 34.4918 16.8827 34.4918 16.712C34.4918 16.456 34.4224 16.2587 34.2838 16.12C34.1451 15.9813 33.9424 15.8747 33.6758 15.8C33.4198 15.7147 33.1104 15.6347 32.7478 15.56C32.3638 15.4853 31.9904 15.3947 31.6278 15.288C31.2758 15.1707 30.9558 15.0267 30.6678 14.856C30.3904 14.6853 30.1664 14.4667 29.9958 14.2C29.8358 13.9333 29.7558 13.608 29.7558 13.224C29.7558 12.7547 29.8784 12.3333 30.1238 11.96C30.3798 11.5867 30.7424 11.2933 31.2118 11.08C31.6918 10.856 32.2624 10.744 32.9238 10.744C33.8624 10.744 34.6091 10.9627 35.1638 11.4C35.7291 11.8267 36.0598 12.4293 36.1558 13.208H34.3318C34.2784 12.9093 34.1291 12.68 33.8838 12.52C33.6384 12.3493 33.3131 12.264 32.9078 12.264C32.4918 12.264 32.1718 12.344 31.9478 12.504C31.7344 12.6533 31.6278 12.856 31.6278 13.112C31.6278 13.272 31.6918 13.4213 31.8198 13.56C31.9584 13.688 32.1558 13.8 32.4118 13.896C32.6678 13.9813 32.9824 14.0667 33.3558 14.152C33.9531 14.2693 34.4811 14.408 34.9398 14.568C35.3984 14.728 35.7611 14.9627 36.0278 15.272C36.2944 15.5813 36.4278 16.0187 36.4278 16.584C36.4384 17.096 36.3051 17.5493 36.0278 17.944C35.7611 18.3387 35.3824 18.648 34.8918 18.872C34.4011 19.0853 33.8144 19.192 33.1318 19.192ZM41.5135 19C40.9695 19 40.4948 18.9147 40.0895 18.744C39.6948 18.5733 39.3855 18.2907 39.1615 17.896C38.9375 17.5013 38.8255 16.968 38.8255 16.296V12.552H37.4495V10.936H38.8255L39.0495 8.808H40.7455V10.936H42.9375V12.552H40.7455V16.296C40.7455 16.7013 40.8308 16.984 41.0015 17.144C41.1828 17.2933 41.4815 17.368 41.8975 17.368H42.8895V19H41.5135Z" fill="white"/>
                                </svg>
                            </div>
                            <div class="w-full h-80 bg-gray-100 rounded-t-2xl overflow-hidden">
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="" class="w-full h-full object-cover transition-all duration-300 transform group-hover:scale-110" />
                            </div>
                        </div>
                        <div class="w-full bg-white rounded-b-2xl p-5">
                            <span>{{ $product->product_category->name }}</span>
                            <h1 class="text-lg font-bold group-hover:text-pink-primary">{{ $product->product_name }}</h1>
                            <span class="text-pink-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="w-full md:grid-cols-2 lg:grid-cols-4">
                        <h1>Belum ada produk terdaftar</h1>
                    </div>
                @endforelse
            </div>
        </section>
        {{-- START : OUR CATALOG --}}
        {{-- START : CTA --}}
        <section class="w-full bg-pink-addfirst py-20">
            <div class="w-full max-w-screen-xl mx-auto grid grid-cols-1 lg:grid-cols-2 md:gap-5 px-4 md:px-10 xl:px-5">
                {{-- LEFT --}}
                <h1 class="text-3xl text-center md:text-left md:text-4xl font-bold lg:leading-[1.2]">Jelajahi dan temukan rangkaian bunga terbaik untuk setiap momen.</h1>
                {{-- RIGHT --}}
                <div class="w-full flex items-center justify-end mt-10 lg:mt-0">
                    <a href="https://wa.me/6285803685203" class="w-full sm:w-44">
                        <x-primary-button class="w-full sm:w-44">Hubungi Kami</x-primary-button>
                    </a>
                </div>
            </div>
        </section>
        {{-- END : CTA --}}
        {{-- START : FOOTER --}}
        <footer class="w-full bg-pink-secondary">
            <div class="w-full max-w-screen-xl mx-auto flex flex-col items-center text-center space-y-5 px-4 md:px-10 xl:px-5 py-20">
                <h1 class="text-3xl md:text-4xl font-bold">Temukan Qiyana Bouquet</h1>
                <a href="mailto:qiyanabouquet@gmail.com" class="hover:underline">qiyanabouquet@gmail.com</a>
                <a href="https://wa.me/6285803685203" class="hover:underline">+62 858-0368-5203</a>
                <a href="#" class="hover:underline">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum, in.</a>
                <div class="w-full flex justify-center space-x-3">
                    {{-- SINGLE ITEM --}}
                    <div class="w-10 h-10">
                        <a href="" class="w-full h-full flex justify-center items-center bg-white rounded-lg">
                            <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.46384 18V9.78936H9.35853L9.79192 6.5895H6.46376V4.54653C6.46376 3.6201 6.73394 2.98879 8.12938 2.98879L9.90907 2.98799V0.126072C9.60126 0.0871459 8.54474 0 7.31576 0C4.74974 0 2.993 1.49118 2.993 4.22972V6.5895H0.0908813V9.78936H2.993V17.9999H6.46384V18Z" fill="#DC5759"/>
                            </svg>                                
                        </a>
                    </div>
                    {{-- SINGLE ITEM --}}
                    <div class="w-10 h-10">
                        <a href="" class="w-full h-full flex justify-center items-center bg-white rounded-lg">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.027 0.701484V0.698242H12.871L13.1794 0.759834C13.385 0.79982 13.5717 0.852222 13.7394 0.917056C13.9071 0.981889 14.0694 1.05753 14.2263 1.14397C14.3832 1.23041 14.5255 1.31849 14.6532 1.40817C14.7798 1.49678 14.8934 1.59079 14.994 1.6902C15.0936 1.79069 15.2488 1.81662 15.4598 1.768C15.6708 1.71937 15.8981 1.65183 16.1415 1.56539C16.385 1.47895 16.6258 1.3817 16.8638 1.27364C17.1019 1.16558 17.2469 1.09697 17.2988 1.06779C17.3497 1.03755 17.3767 1.02134 17.38 1.01917L17.3832 1.01431L17.3994 1.0062L17.4157 0.998098L17.4319 0.989994L17.4481 0.981889L17.4514 0.977027L17.4562 0.973785L17.4611 0.970543L17.4644 0.965681L17.4806 0.960818L17.4968 0.957577L17.4936 0.981889L17.4887 1.0062L17.4806 1.03051L17.4725 1.05483L17.4644 1.07104L17.4562 1.08724L17.4481 1.11156C17.4427 1.12776 17.4373 1.14937 17.4319 1.17639C17.4265 1.20341 17.3751 1.31145 17.2777 1.50056C17.1803 1.68966 17.0586 1.88146 16.9125 2.07596C16.7664 2.27046 16.6355 2.4174 16.5197 2.51683C16.4029 2.61732 16.3255 2.68755 16.2876 2.72753C16.2498 2.76859 16.2038 2.8064 16.1497 2.84099L16.0685 2.89448L16.0523 2.90259L16.036 2.91069L16.0328 2.91555L16.0279 2.91879L16.0231 2.92204L16.0198 2.9269L16.0036 2.935L15.9873 2.94311L15.9841 2.94797L15.9792 2.95121L15.9744 2.95445L15.9711 2.95932L15.9679 2.96418L15.963 2.96742L15.9581 2.97066L15.9549 2.97552H16.036L16.4905 2.87827C16.7935 2.81344 17.0829 2.7351 17.3589 2.64325L17.7971 2.49738L17.8458 2.48117L17.8701 2.47306L17.8864 2.46496L17.9026 2.45685L17.9188 2.44875L17.935 2.44065L17.9675 2.43578L18 2.43254V2.46496L17.9919 2.4682L17.9837 2.47306L17.9805 2.47793L17.9756 2.48117L17.9708 2.48441L17.9675 2.48927L17.9643 2.49413L17.9594 2.49738L17.9545 2.50062L17.9513 2.50548L17.948 2.51034L17.9432 2.51358L17.935 2.52979L17.9269 2.546L17.9221 2.54924C17.9199 2.55248 17.8512 2.64432 17.7159 2.82479C17.5807 3.00632 17.5076 3.09816 17.4968 3.10033C17.486 3.10357 17.4708 3.11978 17.4514 3.14895C17.433 3.1792 17.3183 3.29969 17.1073 3.5104C16.8963 3.72111 16.6896 3.90858 16.4873 4.07283C16.2839 4.23816 16.181 4.4413 16.1789 4.68227C16.1756 4.92215 16.1632 5.19339 16.1415 5.49593C16.1199 5.79849 16.0793 6.12535 16.0198 6.47654C15.9603 6.82773 15.8683 7.22483 15.7439 7.66786C15.6195 8.11088 15.468 8.54311 15.2894 8.96453C15.1109 9.38595 14.9242 9.76414 14.7295 10.0991C14.5347 10.4341 14.3561 10.7177 14.1938 10.9501C14.0315 11.1824 13.8665 11.4012 13.6988 11.6065C13.5311 11.8118 13.319 12.0431 13.0626 12.3002C12.805 12.5563 12.6644 12.6968 12.6406 12.7216C12.6157 12.7454 12.5096 12.834 12.3224 12.9875C12.1363 13.142 11.9361 13.2965 11.7219 13.451C11.5087 13.6045 11.3129 13.7325 11.1343 13.8352C10.9558 13.9378 10.7405 14.055 10.4883 14.1869C10.2373 14.3198 9.9657 14.443 9.67355 14.5564C9.38139 14.6699 9.07301 14.7752 8.74839 14.8725C8.42377 14.9697 8.10998 15.0454 7.807 15.0994C7.50404 15.1534 7.16048 15.1994 6.77634 15.2372L6.20015 15.2939V15.302H5.14515V15.2939L5.00718 15.2858C4.91522 15.2804 4.83947 15.275 4.77995 15.2696C4.72045 15.2642 4.49591 15.2345 4.10637 15.1805C3.71683 15.1264 3.41116 15.0724 3.18933 15.0184C2.96752 14.9643 2.63748 14.8617 2.19925 14.7104C1.76102 14.5591 1.38608 14.4062 1.07445 14.2517C0.763906 14.0983 0.569136 14.001 0.490141 13.96C0.412233 13.92 0.324586 13.8703 0.227201 13.8108L0.0811237 13.7217L0.0778937 13.7168L0.0730083 13.7136L0.068139 13.7104L0.0648928 13.7055L0.048662 13.6974L0.0324312 13.6893L0.0292012 13.6844L0.0243157 13.6812L0.0194465 13.6779L0.0162003 13.6731L0.0129704 13.6682L0.0080849 13.665H-3.05176e-05V13.6326L0.0162003 13.6358L0.0324312 13.6407L0.10547 13.6488C0.154162 13.6542 0.28672 13.6623 0.503125 13.6731C0.719548 13.6839 0.949474 13.6839 1.19294 13.6731C1.4364 13.6623 1.68528 13.6379 1.93955 13.6001C2.19384 13.5623 2.49411 13.4975 2.84037 13.4056C3.18663 13.3138 3.50476 13.2046 3.79476 13.0782C4.08366 12.9507 4.28924 12.8556 4.41153 12.793C4.53271 12.7314 4.71774 12.6168 4.96661 12.4493L5.33992 12.1981L5.34316 12.1932L5.34803 12.19L5.35292 12.1868L5.35615 12.1819L5.35939 12.177L5.36426 12.1738L5.36915 12.1706L5.37238 12.1657L5.38861 12.1608L5.40484 12.1576L5.40808 12.1414L5.41295 12.1252L5.41784 12.1219L5.42107 12.1171L5.29122 12.109C5.20466 12.1036 5.1208 12.0982 5.03964 12.0928C4.95849 12.0874 4.83135 12.063 4.65822 12.0198C4.4851 11.9766 4.29845 11.9118 4.09826 11.8253C3.89808 11.7389 3.70331 11.6362 3.51395 11.5174C3.3246 11.3985 3.18771 11.2996 3.10331 11.2207C3.01999 11.1429 2.91178 11.0327 2.77869 10.8901C2.64668 10.7464 2.53198 10.5989 2.4346 10.4476C2.33721 10.2963 2.24416 10.1218 2.15544 9.92407L2.02071 9.62908L2.01259 9.60476L2.00448 9.58045L1.99961 9.56424L1.99636 9.54803L2.02071 9.55128L2.04506 9.55614L2.22359 9.58045C2.34263 9.59666 2.52929 9.60206 2.78356 9.59666C3.03785 9.59126 3.21368 9.58045 3.31106 9.56424C3.40845 9.54803 3.46796 9.53722 3.4896 9.53183L3.52206 9.52372L3.56264 9.51562L3.60322 9.50751L3.60646 9.50265L3.61133 9.49941L3.61622 9.49617L3.61945 9.4913L3.58698 9.4832L3.55452 9.4751L3.52206 9.46699L3.4896 9.45889L3.45714 9.45078C3.4355 9.44538 3.39764 9.43457 3.34352 9.41837C3.28942 9.40216 3.14335 9.34272 2.90529 9.24007C2.66725 9.13743 2.47788 9.03747 2.33721 8.94022C2.19619 8.84269 2.06173 8.73602 1.93469 8.62091C1.80808 8.50421 1.66905 8.35401 1.51755 8.17032C1.36607 7.98663 1.23082 7.77321 1.11178 7.53009C0.992761 7.28696 0.903492 7.05465 0.843973 6.83312C0.784694 6.61291 0.745584 6.38776 0.727127 6.16048L0.697896 5.8201L0.714126 5.82334L0.730357 5.8282L0.746588 5.83631L0.762819 5.84441L0.77905 5.85252L0.795281 5.86062L1.04686 5.97408C1.21459 6.04972 1.42288 6.11456 1.67175 6.16858C1.92063 6.2226 2.0694 6.25233 2.11809 6.25773L2.19113 6.26583H2.33721L2.33398 6.26097L2.32909 6.25773L2.32423 6.25448L2.32098 6.24962L2.31775 6.24476L2.31286 6.24152L2.30799 6.23828L2.30475 6.23341L2.28852 6.22531L2.27229 6.21721L2.26906 6.21234L2.26417 6.2091L2.2593 6.20586L2.25606 6.201L2.23983 6.19289L2.22359 6.18479L2.22036 6.17993C2.21712 6.17775 2.17058 6.14318 2.08076 6.07619C1.99203 6.00812 1.89898 5.92006 1.80159 5.812C1.70421 5.70393 1.60682 5.59048 1.50944 5.47162C1.41187 5.35249 1.32497 5.22503 1.24974 5.09072C1.17401 4.95566 1.09393 4.78383 1.00953 4.57529C0.926215 4.36783 0.862914 4.15874 0.819627 3.94803C0.776355 3.73732 0.752009 3.52932 0.746588 3.324C0.741183 3.11869 0.746588 2.94311 0.762819 2.79723C0.77905 2.65136 0.811511 2.48656 0.860204 2.30287C0.908896 2.11918 0.979241 1.92468 1.0712 1.71937L1.20917 1.41141L1.21728 1.3871L1.2254 1.36279L1.23028 1.35955L1.23351 1.35468L1.23676 1.34982L1.24163 1.34658L1.24651 1.34982L1.24974 1.35468L1.25299 1.35955L1.25786 1.36279L1.26275 1.36603L1.26597 1.37089L1.26922 1.37575L1.27409 1.379L1.28221 1.3952L1.29032 1.41141L1.29521 1.41465L1.29844 1.41952L1.51755 1.66264C1.66363 1.82473 1.83676 2.00573 2.03694 2.20562C2.23713 2.40552 2.34804 2.50926 2.36967 2.51683C2.39132 2.52546 2.41836 2.55031 2.45083 2.59138C2.48329 2.63137 2.5915 2.727 2.77544 2.87827C2.9594 3.02955 3.20016 3.20515 3.49772 3.40505C3.79529 3.60494 4.12531 3.80215 4.4878 3.99665C4.8503 4.19115 5.23984 4.36674 5.65642 4.52343C6.07301 4.68011 6.36517 4.78276 6.53288 4.83139C6.70061 4.88001 6.98735 4.94214 7.39312 5.01778C7.79889 5.09343 8.10458 5.14205 8.31016 5.16366C8.51575 5.18526 8.65643 5.1977 8.73216 5.20094L8.84578 5.20418L8.84255 5.17987L8.83766 5.15555L8.8052 4.95295C8.78356 4.81788 8.77274 4.62878 8.77274 4.38566C8.77274 4.14253 8.79168 3.91832 8.82955 3.71301C8.86743 3.50769 8.92424 3.29969 8.99997 3.08898C9.07572 2.87827 9.14985 2.70915 9.22233 2.58166C9.29592 2.45523 9.39222 2.31098 9.51124 2.14889C9.63028 1.98681 9.78447 1.81933 9.97382 1.64643C10.1632 1.47354 10.3796 1.31956 10.6231 1.18449C10.8665 1.04943 11.0911 0.946766 11.2966 0.876535C11.5022 0.806304 11.6754 0.760369 11.816 0.738763C11.9567 0.717157 12.027 0.704726 12.027 0.701484Z" fill="#DC5759"/>
                            </svg>                                                                
                        </a>
                    </div>
                    {{-- SINGLE ITEM --}}
                    <div class="w-10 h-10">
                        <a href="" class="w-full h-full flex justify-center items-center bg-white rounded-lg">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 0C12.5951 0 14.3928 -0.000195332 15.6875 0.856445C16.2657 1.239 16.761 1.73434 17.1436 2.3125C18.0002 3.60723 18 5.40493 18 9C18 12.5951 18.0002 14.3928 17.1436 15.6875C16.761 16.2657 16.2657 16.761 15.6875 17.1436C14.3928 18.0002 12.5951 18 9 18C5.40493 18 3.60723 18.0002 2.3125 17.1436C1.73434 16.761 1.239 16.2657 0.856445 15.6875C-0.000195332 14.3928 0 12.5951 0 9C0 5.40493 -0.000195531 3.60723 0.856445 2.3125C1.239 1.73434 1.73434 1.239 2.3125 0.856445C3.60723 -0.000195531 5.40493 0 9 0ZM9 4.34082C6.42675 4.34082 4.34094 6.42678 4.34082 9C4.34082 11.5733 6.42668 13.6592 9 13.6592C11.5732 13.6591 13.6592 11.5733 13.6592 9C13.6591 6.42684 11.5732 4.34091 9 4.34082ZM9 5.91699C10.7025 5.91708 12.0829 7.29746 12.083 9C12.083 10.7026 10.7026 12.0829 9 12.083C7.2973 12.083 5.91699 10.7027 5.91699 9C5.91711 7.29741 7.29738 5.91699 9 5.91699ZM13.8438 3.01172C13.2392 3.01172 12.7482 3.50192 12.748 4.10645C12.748 4.7111 13.2391 5.20117 13.8438 5.20117C14.4482 5.20092 14.9385 4.71094 14.9385 4.10645C14.9383 3.50208 14.4481 3.01198 13.8438 3.01172Z" fill="#DC5759"/>
                            </svg>                                
                        </a>
                    </div>
                    {{-- SINGLE ITEM --}}
                    <div class="w-10 h-10">
                        <a href="" class="w-full h-full flex justify-center items-center bg-white rounded-lg">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 2.42005C0 1.84284 0.202708 1.36665 0.608108 0.991481C1.01351 0.616295 1.54055 0.428711 2.18919 0.428711C2.82626 0.428711 3.34169 0.613403 3.73552 0.982823C4.14092 1.36378 4.34363 1.86016 4.34363 2.472C4.34363 3.02611 4.14672 3.48786 3.7529 3.85728C3.3475 4.23823 2.81467 4.42871 2.15444 4.42871H2.13707C1.49999 4.42871 0.984562 4.23823 0.590734 3.85728C0.196905 3.47633 0 2.99725 0 2.42005ZM0.225869 17.5716V6.00447H4.08301V17.5716H0.225869ZM6.22008 17.5716H10.0772V11.1127C10.0772 10.7086 10.1236 10.3969 10.2162 10.1776C10.3784 9.78512 10.6245 9.45323 10.9546 9.18195C11.2847 8.91066 11.6988 8.77503 12.1969 8.77503C13.4942 8.77503 14.1429 9.6466 14.1429 11.3897V17.5716H18V10.9395C18 9.23101 17.5946 7.9352 16.7838 7.05208C15.973 6.16897 14.9015 5.72741 13.5695 5.72741C12.0753 5.72741 10.9112 6.3681 10.0772 7.64949V7.68412H10.0598L10.0772 7.64949V6.00447H6.22008C6.24324 6.37387 6.25483 7.52249 6.25483 9.45035C6.25483 11.3782 6.24324 14.0853 6.22008 17.5716Z" fill="#DC5759"/>
                            </svg>                                
                        </a>
                    </div>
                </div>
            </div>
        </footer>
        {{-- END : FOOTER --}}

        @include('sweetalert::alert')
        {{-- SCRIPT --}}
        <script>
            let mainNavbar = document.querySelector('#main-navbar')

            window.addEventListener('scroll', function() {
                let scrollYPos = this.pageYOffset;

                if (scrollYPos > 100) {
                    mainNavbar.classList.add('bg-white')
                    mainNavbar.classList.add('shadow-xl')
                } else {
                    mainNavbar.classList.remove('bg-white')
                    mainNavbar.classList.remove('shadow-xl')
                }
            })

            const navLink = document.querySelectorAll('.nav-link')

            function scrollToContent(id) {
                const element = document.getElementById(id);

                if (element) {
                    element.scrollIntoView({ behavior: 'smooth' });
                    
                    element.blur();
                }
            }

            navLink.forEach(link => {
                let target = link.getAttribute('id') + '-section'

                link.addEventListener('click', function() {
                    scrollToContent(target)
                })
            });

            const checkNumberInput = (evt) => {
                evt = evt || window.event;
                let charCode = evt.which || evt.keyCode;

                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46 && charCode !== 45) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            };

            let qty = document.querySelector('#qty')
            
            qty.addEventListener('keypress', checkNumberInput)
        </script>
    </body>
</html>
