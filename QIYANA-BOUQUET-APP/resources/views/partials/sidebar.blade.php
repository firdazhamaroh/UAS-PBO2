<aside x-cloak :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="w-full h-screen overflow-y-auto custom-vertical-scrollbar min-w-[325px] max-w-[325px] fixed top-0 left-0 z-50 lg:sticky transition-all duration-300 transform lg:transform-none bg-white shadow-xl lg:shadow-none border-r border-gray-300 pb-10">
    {{-- TOP LOGO --}}
    <div class="w-full flex justify-center py-16">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-28" />
    </div>
    {{-- MENU LIST --}}
    <div class="w-full">
        {{-- SINGLE GROUP --}}
        <div class="w-full">
            <div class="px-7 pb-3">
                <span class="text-sm font-bold">Menu Utama</span>
            </div>
            <ul class="w-full space-y-3 px-7 pt-0">
                {{-- SINGLE MENU --}}
                <li>
                    <a href="{{ route('admin.index') }}" class="flex items-center space-x-1 rounded-md {{ request()->routeIs('admin.index') ? 'text-pink-primary hover:text-pink-700 hover:bg-pink-addfirst' : 'text-gray-500 hover:text-pink-primary hover:bg-gray-100' }}">
                        <div class="w-10 h-10 flex justify-center items-center">
                            <iconify-icon icon="cuida:dashboard-outline" width="22" height="22"></iconify-icon>
                        </div>
                        <span class="text-sm">Dashboard</span>
                    </a>
                </li>
                {{-- SINGLE MENU --}}
                <li x-data="{ openSidebarAccordion: false }" x-on:click.outside="openSidebarAccordion = false">
                    {{-- DROPDOWN BUTTON --}}
                    <button x-on:click="openSidebarAccordion = !openSidebarAccordion" class="w-full flex justify-between items-center rounded-md {{ request()->routeIs('produk.*', 'kategori-produk.*', 'diskon.*') ? 'text-pink-primary hover:text-pink-700 hover:bg-pink-addfirst' : 'text-gray-500 hover:text-pink-primary hover:bg-gray-100' }}">
                        <div class="flex items-center space-x-1">
                            <div class="w-10 h-10 flex justify-center items-center">
                                <iconify-icon icon="icon-park-outline:ad-product" width="22" height="22"></iconify-icon>
                            </div>
                            <span class="text-sm">Manajemen Produk</span>
                        </div>
                        <iconify-icon icon="heroicons:chevron-right-16-solid" width="20" height="20" :class="openSidebarAccordion ? 'rotate-90' : 'rotate-0'" class="duration-300 transform {{ request()->routeIs('produk.*', 'kategori-produk.*', 'diskon.*') ? 'rotate-90' : 'rotate-0' }} mr-4"></iconify-icon>
                    </button>
                    {{-- DROPDOWN MENU --}}
                    <div :class="openSidebarAccordion ? 'max-h-[1000px]' : 'max-h-0'" class="w-full {{ request()->routeIs('produk.*', 'kategori-produk.*', 'diskon.*') ? 'max-h-[1000px]' : 'max-h-0' }} overflow-hidden transition-all duration-300">
                        <ul class="space-y-3 p-5">
                            {{-- SINGLE SUB MENU --}}
                            <li>
                                <a href="{{ route('kategori-produk.index') }}" class="inline-flex items-center space-x-1 transition-all duration-300 transform hover:translate-x-1 {{ request()->routeIs('kategori-produk.*') ? 'text-pink-primary hover:text-pink-700' : 'text-gray-500 hover:text-pink-primary' }}">
                                    <iconify-icon icon="ph:dot-outline" width="20" height="20"></iconify-icon>
                                    <span class="text-sm">Kategori</span>
                                </a>
                            </li>
                            {{-- SINGLE SUB MENU --}}
                            <li>
                                <a href="{{ route('produk.index') }}" class="inline-flex items-center space-x-1 transition-all duration-300 transform hover:translate-x-1 {{ request()->routeIs('produk.*') ? 'text-pink-primary hover:text-pink-700' : 'text-gray-500 hover:text-pink-primary' }}">
                                    <iconify-icon icon="ph:dot-outline" width="20" height="20"></iconify-icon>
                                    <span class="text-sm">Produk</span>
                                </a>
                            </li>
                            {{-- SINGLE SUB MENU --}}
                            <li>
                                <a href="{{ route('diskon.index') }}" class="inline-flex items-center space-x-1 transition-all duration-300 transform hover:translate-x-1 {{ request()->routeIs('diskon.*') ? 'text-pink-primary hover:text-pink-700' : 'text-gray-500 hover:text-pink-primary' }}">
                                    <iconify-icon icon="ph:dot-outline" width="20" height="20"></iconify-icon>
                                    <span class="text-sm">Diskon</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- SINGLE MENU --}}
                <li>
                    <a href="{{ route('transaksi.index') }}" class="flex items-center space-x-1 rounded-md {{ request()->routeIs('transaksi.*') ? 'text-pink-primary hover:text-pink-700 hover:bg-pink-addfirst' : 'text-gray-500 hover:text-pink-primary hover:bg-gray-100' }}">
                        <div class="w-10 h-10 flex justify-center items-center">
                            <iconify-icon icon="uil:transaction" width="22" height="22"></iconify-icon>
                        </div>
                        <span class="text-sm">Transaksi</span>
                    </a>
                </li>
                {{-- SINGLE MENU --}}
                <li>
                    <a href="{{ route('manajemen-pelanggan.index') }}" class="flex items-center space-x-1 rounded-md {{ request()->routeIs('manajemen-pelanggan.*') ? 'text-pink-primary hover:text-pink-700 hover:bg-pink-addfirst' : 'text-gray-500 hover:text-pink-primary hover:bg-gray-100' }}">
                        <div class="w-10 h-10 flex justify-center items-center">
                            <iconify-icon icon="ph:users-three" width="24" height="24"></iconify-icon>
                        </div>
                        <span class="text-sm">Manajemen Pelanggan</span>
                    </a>
                </li>
            </ul>
        </div>
        {{-- SINGLE GROUP --}}
        <div class="w-full pt-5">
            <div class="px-7 pb-3">
                <span class="text-sm font-bold">Manajemen Tampilan</span>
            </div>
            <ul class="w-full space-y-3 px-7 pt-0">
                {{-- SINGLE MENU --}}
                <li>
                    <a href="{{ route('slider-homepage.index') }}" class="flex items-center space-x-1 rounded-md {{ request()->routeIs('slider-homepage.*') ? 'text-pink-primary hover:text-pink-700 hover:bg-pink-addfirst' : 'text-gray-500 hover:text-pink-primary hover:bg-gray-100' }}">
                        <div class="w-10 h-10 flex justify-center items-center">
                            <iconify-icon icon="solar:slider-horizontal-linear" width="20" height="20"></iconify-icon>                                    
                        </div>
                        <span class="text-sm">Slider Homepage</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    {{-- BOTTOM ADDRESS --}}
    <div class="relative w-full flex justify-center items-center px-5 mt-36">
        <div class="w-full flex justify-center absolute top-0 left-0 transform -translate-y-1/2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-28" />
        </div>
        <div class="w-full flex flex-col items-center text-center bg-pink-addfirst rounded-lg py-16">
            <h1 class="text-xl font-bold">Qiyana Bouquet</h1>
            <p class="text-sm text-gray-500">Jl. Raya Kajen</p>
        </div>
    </div>
</aside>