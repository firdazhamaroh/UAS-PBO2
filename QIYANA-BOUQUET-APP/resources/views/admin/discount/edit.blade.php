@extends('layouts.dashboard')

@section('title', 'Edit Diskon')

@section('content')
<div class="w-full space-y-5 xl:space-y-10">
    <div class="w-full bg-white rounded-lg p-5 py-10 lg:px-10">
        <h1 class="text-2xl font-bold mb-6">Edit Diskon</h1>
        <form action="{{ route('diskon.update', $discount->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama Produk --}}
            <div>
                <label for="product_id" class="block text-sm font-medium text-gray-700">Produk</label>
                <select name="product_id" id="product_id" class="w-full mt-1 rounded border-gray-300 shadow-sm">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ $discount->product_id == $product->id ? 'selected' : '' }}>
                            {{ $product->product_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Persentase --}}
            <div>
                <label for="percentage" class="block text-sm font-medium text-gray-700">Persentase Diskon (%)</label>
                <input type="number" name="percentage" id="percentage" class="w-full mt-1 rounded border-gray-300 shadow-sm" value="{{ $discount->percentage }}" min="0" max="100" required>
            </div>

            {{-- Tanggal Mulai --}}
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="w-full mt-1 rounded border-gray-300 shadow-sm" value="{{ $discount->start_date->format('Y-m-d') }}" required>
            </div>

            {{-- Tanggal Berakhir --}}
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Berakhir</label>
                <input type="date" name="end_date" id="end_date" class="w-full mt-1 rounded border-gray-300 shadow-sm" value="{{ $discount->end_date->format('Y-m-d') }}" required>
            </div>

            <div class="flex justify-end">
                <x-primary-button type="submit" class="w-40">Simpan Perubahan</x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
