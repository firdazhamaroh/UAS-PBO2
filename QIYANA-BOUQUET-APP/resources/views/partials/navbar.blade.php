<div class="w-full h-16 lg:h-20 flex justify-center items-center bg-white border-b border-gray-300 p-3 lg:p-5">
    <div class="w-full max-w-7xl flex justify-between lg:justify-end">
        {{-- SIDEBAR BUTTON --}}
        <button x-on:click="sidebarOpen = true" class="w-10 h-10 flex justify-center items-center lg:hidden transition-all duration-300 hover:bg-gray-200 border border-gray-300 rounded-md">
            <iconify-icon icon="healthicons:ui-menu" width="24" height="24"></iconify-icon>
        </button>
        {{-- DROPDOWN --}}
        <div x-data="{ openDropdownNavbar: false }" class="relative z-10">
            {{-- DROPDOWN BUTTON --}}
            <button x-on:click="openDropdownNavbar = true" class="w-20 h-10 flex items-center justify-between border border-gray-300 transition-all duration-300 hover:bg-gray-200 rounded-full px-1">
                <div class="w-8 h-8 flex items-center bg-gray-100 border border-gray-300 rounded-full px-1">
                    <img src="{{ asset('images/logo.png') }}" alt="MENU" class="w-full" />
                </div>
                <iconify-icon icon="fluent:chevron-down-16-regular" width="16" height="16"></iconify-icon>
            </button>
            {{-- DROPDOWN MENU --}}
            <div
                x-show="openDropdownNavbar" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
                class="w-full h-full lg:w-96 fixed lg:absolute lg:left-full mx-auto lg:mx-0 transform -translate-x-1/2 lg:-translate-x-full left-1/2 z-40 lg:z-30 top-16 lg:top-full origin-top-right lg:bg-black-primary bg-opacity-50 backdrop-blur-xl lg:bg-transparent lg:bg-opacity-0 lg:mt-5 p-5 lg:p-0">
                <div
                    x-on:click.outside="openDropdownNavbar = false" 
                    class="bg-white shadow-2xl border rounded-lg">
                    {{-- TOP INFO --}}
                    <div class="w-full flex gap-3 p-5">
                        <div class="w-12 h-12 flex items-center bg-gray-100 border border-gray-300 rounded-full px-1">
                            <img src="{{ asset('images/logo.png') }}" alt="MENU" class="w-full" />
                        </div>
                        <div>
                            <h1 class="font-bold text-gray-700">{{ Auth::user()->name }}</h1>
                            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    {{-- ACCOUNT SETTING & LOGOUT --}}
                    <ul class="w-full divide-y divide-gray-300 space-y-2 p-5">
                        <li>
                            <a href="{{ route('admin.edit-profile') }}" class="inline-flex items-center space-x-2 transition-all duration-300 text-gray-500 hover:text-pink-primary">
                                <iconify-icon icon="ant-design:setting-outlined" width="24" height="24" class="text-pink-primary"></iconify-icon>
                                <span class="text-sm">Pengaturan Akun</span>
                            </a>
                        </li>
                        <li class="pt-3">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="inline-flex items-center space-x-2 transition-all duration-300 text-gray-500 hover:text-pink-primary">
                                    <iconify-icon icon="cuida:logout-outline" width="24" height="24" class="text-pink-primary"></iconify-icon>
                                    <span class="text-sm">Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>