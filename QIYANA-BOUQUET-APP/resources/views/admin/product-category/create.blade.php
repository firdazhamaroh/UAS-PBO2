@extends('layouts.dashboard')

@section('title', 'Kategori Produk')

@push('styles')

@endpush

@section('content')
    <div class="w-full space-y-5 xl:space-y-10">
        {{-- TOP INFO --}}
        <div class="w-full grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-10">
            {{-- LEFT --}}
            <div class="w-full xl:col-span-2 bg-white rounded-lg p-5 py-10 lg:px-10">
                <div class="w-full flex justify-between items-center">
                    <h1 class="flex text-2xl font-bold leading-normal xl:leading-relaxed">Tambah Kategori Produk</h1>
                </div>
                {{-- MAIN TABLE --}}
                <form action="{{ route('kategori-produk.store') }}" method="POST" class="w-full">
                    @csrf
                    <div class="w-full py-10 space-y-3">
                        {{-- SINGLE GROU INPUT --}}
                        <div id="input-group">
                            <x-input-label for="category_name" :value="__('Nama Kategori')" />
                            <div class="relative">
                                <div class="absolute top-1/2 left-0 transform -translate-y-1/2 z-10 ml-5 mt-0.5">
                                    <iconify-icon icon="material-symbols:category-outline-rounded" width="20" height="20"></iconify-icon>
                                </div>
                                <x-text-input id="category_name" class="w-full placeholder-gray-400 pl-12 pr-4 py-3" type="text" name="category_name" :value="old('category_name')" placeholder="Masukkan nama kategori produk"  />
                            </div>
                            <x-input-error id="input-error" :messages="$errors->get('category_name')" class="mt-2" />
                        </div>
                    </div>
                    {{-- BOTTOM BUTTON GROUP --}}
                    <div class="w-full flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3 md:justify-end">
                        <a href="{{ route('kategori-produk.index') }}">
                            <x-secondary-button class="w-full md:w-40">Kembali</x-secondary-button>
                        </a>
                        <x-primary-button type="submit" class="w-full md:w-40">Simpan Data</x-primary-button>
                    </div>
                </form>
            </div>
            {{-- RIGHT --}}
            <div class="w-full flex flex-col space-y-5 lg:space-y-10">
                {{-- TOP --}}
                <div class="w-full flex items-center space-x-2 lg:space-x-5 bg-white rounded-lg p-5 lg:p-8">
                    <div class="w-20 min-w-20 h-20 flex justify-center items-center bg-green-300 bg-opacity-50 text-green-500 rounded-full">
                        <iconify-icon icon="fluent-mdl2:product-variant" width="30" height="30"></iconify-icon>
                    </div>
                    <div class="w-full">
                        <h1 class="text-xl md:text-2xl lg:text-3xl font-bold">{{ $productCategoryCount }}</h1>
                        <p class="text-sm text-gray-500">Kategori Produk</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- LOCAL SCRIPT --}}
    <script>
        
    </script>
@endpush