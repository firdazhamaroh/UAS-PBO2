@extends('layouts.dashboard')

@section('title', 'Buat Diskon')

@section('content')
<div class="w-full space-y-5 xl:space-y-10">
    <div class="w-full bg-white rounded-lg p-5 py-10 lg:px-10">
        <div class="w-full flex justify-between items-center">
            <h1 class="text-2xl font-bold">Buat Diskon Baru</h1>
        </div>

        <form action="{{ route('diskon.store') }}" method="POST" class="w-full mt-10 space-y-5">
            @csrf

            {{-- Produk --}}
            <div>
                <x-input-label for="product_id" :value="'Pilih Produk'" />
                <select name="product_id" id="product_id" class="w-full border-gray-300 rounded-lg pl-4 pr-4 py-3">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
            </div>

            {{-- Persentase Diskon --}}
            <div>
                <x-input-label for="percentage" :value="'Persentase Diskon (%)'" />
                <x-text-input id="percentage" type="number" step="0.01" name="percentage" class="w-full pl-4 pr-4 py-3" placeholder="Contoh: 10.00" />
                <x-input-error :messages="$errors->get('percentage')" class="mt-2" />
            </div>

            {{-- Tanggal Mulai --}}
            <div>
                <x-input-label for="start_date" :value="'Tanggal Mulai'" />
                <x-text-input id="start_date" type="date" name="start_date" class="w-full pl-4 pr-4 py-3" />
                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
            </div>

            {{-- Tanggal Berakhir --}}
            <div>
                <x-input-label for="end_date" :value="'Tanggal Berakhir'" />
                <x-text-input id="end_date" type="date" name="end_date" class="w-full pl-4 pr-4 py-3" />
                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-3">
                <a href="{{ route('diskon.index') }}">
                    <x-secondary-button class="w-40">Kembali</x-secondary-button>
                </a>
                <x-primary-button type="submit" class="w-40">Simpan Diskon</x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
