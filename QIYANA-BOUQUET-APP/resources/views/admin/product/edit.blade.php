@extends('layouts.dashboard')

@section('title', 'Edit Produk')

@push('styles')
@endpush

@section('content')
<div class="w-full space-y-5 xl:space-y-10">
    <div class="w-full grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-10">
        {{-- LEFT --}}
        <div class="w-full xl:col-span-2 bg-white rounded-lg p-5 py-10 lg:px-10">
            <div class="w-full flex justify-between items-center">
                <h1 class="flex text-2xl font-bold leading-normal xl:leading-relaxed">Edit Produk</h1>
            </div>

            <form action="{{ route('produk.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="w-full">
                @csrf
                @method('PUT')
                <div class="w-full py-10 space-y-5">
                    {{-- Kategori --}}
                    <div id="input-group">
                        <x-input-label for="product_category_id" :value="__('Kategori Produk')" />
                        <select name="product_category_id" id="product_category_id" class="w-full border-gray-300 pl-4 pr-4 py-3 rounded-lg">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->product_category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('product_category_id')" class="mt-2" />
                    </div>

                    {{-- Thumbnail --}}
                    <div id="input-group">
                        <x-input-label for="thumbnail" :value="__('Foto Produk (Opsional)')" />
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-40 h-auto mb-2 rounded shadow" alt="Thumbnail">
                        @endif
                        <input type="file" name="thumbnail" id="thumbnail" class="w-full border-gray-300 pl-4 pr-4 py-3 rounded-lg">
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>

                    {{-- Nama Produk --}}
                    <div id="input-group">
                        <x-input-label for="product_name" :value="__('Nama Produk')" />
                        <x-text-input id="product_name" class="w-full pl-4 pr-4 py-3" type="text" name="product_name" :value="old('product_name', $product->product_name)" />
                        <x-input-error :messages="$errors->get('product_name')" class="mt-2" />
                    </div>

                    {{-- Deskripsi --}}
                    <div id="input-group">
                        <x-input-label for="description" :value="__('Deskripsi Produk')" />
                        <textarea name="description" id="description" rows="5" class="w-full border-gray-300 pl-4 pr-4 py-3 rounded-lg">{{ old('description', $product->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    {{-- Harga --}}
                    <div id="input-group">
                        <x-input-label for="price" :value="__('Harga')" />
                        <x-text-input id="price" class="w-full pl-4 pr-4 py-3" type="number" step="0.01" name="price" :value="old('price', $product->price)" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    {{-- Stok --}}
                    <div id="input-group">
                        <x-input-label for="stock" :value="__('Stok')" />
                        <x-text-input id="stock" class="w-full pl-4 pr-4 py-3" type="number" name="stock" :value="old('stock', $product->stock)" />
                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                    </div>

                    {{-- Status --}}
                    <div id="input-group">
                        <x-input-label for="status" :value="__('Status Produk')" />
                        <select name="status" id="status" class="w-full border-gray-300 pl-4 pr-4 py-3 rounded-lg">
                            <option value="live" {{ $product->status == 'live' ? 'selected' : '' }}>Live</option>
                            <option value="archive" {{ $product->status == 'archive' ? 'selected' : '' }}>Arsip</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="w-full flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3 md:justify-end">
                    <a href="{{ route('produk.index') }}">
                        <x-secondary-button class="w-full md:w-40">Kembali</x-secondary-button>
                    </a>
                    <x-primary-button type="submit" class="w-full md:w-40">Perbarui Data</x-primary-button>
                </div>
            </form>
        </div>

        {{-- RIGHT --}}
        <div class="w-full flex flex-col space-y-5 lg:space-y-10">
            <div class="w-full flex items-center space-x-2 lg:space-x-5 bg-white rounded-lg p-5 lg:p-8">
                <div class="w-20 min-w-20 h-20 flex justify-center items-center bg-yellow-300 bg-opacity-50 text-yellow-500 rounded-full">
                    <iconify-icon icon="fluent-mdl2:product-variant" width="30" height="30"></iconify-icon>
                </div>
                <div class="w-full">
                    <h1 class="text-xl md:text-2xl lg:text-3xl font-bold">{{ $productCount }}</h1>
                    <p class="text-sm text-gray-500">Total Produk</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
