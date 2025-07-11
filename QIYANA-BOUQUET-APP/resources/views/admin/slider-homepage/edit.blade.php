@extends('layouts.dashboard')

@section('title', 'Edit Slide Homepage')

@section('content')
    <div class="w-full space-y-5 xl:space-y-10">
        <div class="w-full grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-10">
            {{-- LEFT CONTENT --}}
            <div class="w-full xl:col-span-2 bg-white rounded-lg p-5 py-10 lg:px-10">
                <div class="w-full flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Edit Slide</h1>
                </div>

                <form action="{{ route('slider-homepage.update', Crypt::encrypt($sliderHomepage->id)) }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf
                    @method('PUT')
                    <div class="w-full py-10 space-y-5">
                        {{-- Title --}}
                        <div>
                            <x-input-label for="judul_slide" :value="__('Judul Slide')" />
                            <x-text-input id="judul_slide" name="judul_slide" type="text" class="w-full mt-1" :value="old('judul_slide', $sliderHomepage->title)" />
                            <x-input-error :messages="$errors->get('judul_slide')" class="mt-2" />
                        </div>

                        {{-- Subtitle --}}
                        <div>
                            <x-input-label for="subjudul_slide" :value="__('Subjudul Slide')" />
                            <x-text-input id="subjudul_slide" name="subjudul_slide" type="text" class="w-full mt-1" :value="old('subjudul_slide', $sliderHomepage->subtitle)" />
                            <x-input-error :messages="$errors->get('subjudul_slide')" class="mt-2" />
                        </div>

                        {{-- Image --}}
                        <div>
                            <x-input-label for="image" :value="__('Gambar Slide (kosongkan jika tidak ingin diubah)')" />
                            <input type="file" name="image" id="image" class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        {{-- Link --}}
                        <div>
                            <x-input-label for="link" :value="__('Link Tujuan')" />
                            <x-text-input id="link" name="link" type="text" class="w-full mt-1" :value="old('link', $sliderHomepage->link)" />
                            <x-input-error :messages="$errors->get('link')" class="mt-2" />
                        </div>

                        {{-- Link Text --}}
                        <div>
                            <x-input-label for="link_text" :value="__('Teks Link')" />
                            <x-text-input id="link_text" name="link_text" type="text" class="w-full mt-1" :value="old('link_text', $sliderHomepage->link_text)" />
                            <x-input-error :messages="$errors->get('link_text')" class="mt-2" />
                        </div>

                        {{-- Description --}}
                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi Slide')" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi', $sliderHomepage->description) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Button Group --}}
                    <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3 md:justify-end">
                        <a href="{{ route('slider-homepage.index') }}">
                            <x-secondary-button class="w-full md:w-40">Kembali</x-secondary-button>
                        </a>
                        <x-primary-button type="submit" class="w-full md:w-40">Update Slide</x-primary-button>
                    </div>
                </form>
            </div>

            {{-- RIGHT CONTENT --}}
            <div class="w-full flex flex-col space-y-5 lg:space-y-10">
                <div class="w-full flex items-center space-x-2 lg:space-x-5 bg-white rounded-lg p-5 lg:p-8">
                    <div class="w-20 min-w-20 h-20 flex justify-center items-center bg-blue-300 bg-opacity-50 text-blue-500 rounded-full">
                        <iconify-icon icon="mdi:slideshow" width="30" height="30"></iconify-icon>
                    </div>
                    <div class="w-full">
                        <h1 class="text-xl md:text-2xl lg:text-3xl font-bold">{{ $sliderCount ?? '0' }}</h1>
                        <p class="text-sm text-gray-500">Total Slide</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
