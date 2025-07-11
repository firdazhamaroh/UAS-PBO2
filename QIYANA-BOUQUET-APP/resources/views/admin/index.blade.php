@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="w-full space-y-5 xl:space-y-10">
        {{-- TOP INFO --}}
        <div class="w-full grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-10">
            {{-- LEFT --}}
            <div class="w-full xl:col-span-2 lg:flex lg:gap-x-10 justify-center items-center space-y-10 lg:space-y-0 bg-white rounded-lg p-5 py-10 lg:px-10">
                <div class="w-full space-y-2 lg:w-1/2">
                    <h1 class="flex text-2xl lg:text-2xl xl:text-3xl font-bold leading-normal xl:leading-relaxed">Halo
                        Administrator! 🖐️ <br> Kelola pesanan hari ini yukk!</h1>
                    <p class="text-sm text-gray-500">Kelola kategori, produk, dan penjualan Anda dengan mudah disini! </p>
                    <div class="pt-5">
                        <x-primary-button type="submit" class="w-40">Lihat Pesanan</x-primary-button>
                    </div>
                </div>
                <div class="relative w-full lg:w-1/2 h-80 rounded-lg overflow-hidden">
                    <div class="w-full h-full absolute inset-0 bg-black-primary bg-opacity-30"></div>
                    <img src="{{ asset('images/login.png') }}" alt="Right Image" class="w-full h-full object-cover" />
                </div>
            </div>
            {{-- RIGHT --}}
            <div class="w-full flex flex-col space-y-5 lg:space-y-10">
                {{-- TOP --}}
                <div class="w-full lg:h-full flex items-center space-x-2 lg:space-x-5 bg-white rounded-lg p-5 lg:p-8">
                    <div class="w-20 min-w-20 h-20 flex justify-center items-center bg-green-300 bg-opacity-50 text-green-500 rounded-full">
                        <iconify-icon icon="fluent-mdl2:product-variant" width="32" height="32"></iconify-icon>
                    </div>
                    <div class="w-full">
                        <h1 class="text-xl md:text-2xl lg:text-3xl font-bold">{{ $productCount }}</h1>
                        <p class="text-sm text-gray-500">Total Produk Terdaftar</p>
                    </div>
                </div>
                {{-- BOTTOM --}}
                <div class="w-full lg:h-full flex items-center space-x-2 lg:space-x-5 bg-white rounded-lg p-5 lg:p-8">
                    <div class="w-20 min-w-20 h-20 flex justify-center items-center bg-pink-secondary text-pink-primary rounded-full">
                        <iconify-icon icon="uil:transaction" width="32" height="32"></iconify-icon>
                    </div>
                    <div class="w-full">
                        <h1 class="text-xl md:text-2xl lg:text-3xl font-bold">{{ $transactionCount }}</h1>
                        <p class="text-sm text-gray-500">Jumlah Transaksi Dibuat</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- BOTTOM CHART --}}
        <div class="w-full grid grid-cols-1 xl:grid-cols-4 gap-5 lg:gap-10">
            {{-- LEFT --}}
            <div class="w-full xl:col-span-2 bg-white rounded-lg p-5">
                <div class="py-3">
                    <h1 class="text-xl font-bold">Grafik Penjualan</h1>
                    <p class="text-sm text-gray-500">Aktivitas penjualan Qiyana Bouquet</p>
                </div>
                <div class="w-full rounded-lg mt-5">
                    <div id="line-chart" class="w-full p-5 md:p-0"></div>
                </div>
            </div>
            {{-- RIGHT --}}
            <div class="w-full bg-white rounded-lg p-5">
                <div class="py-3">
                    <h1 class="text-xl font-bold">Aktivitas</h1>
                    <p class="text-sm text-gray-500">Pemesanan</p>
                </div>
            </div>
            {{-- RIGHT --}}
            <div class="w-full bg-white rounded-lg p-5">
                <div class="py-3">
                    <h1 class="text-xl font-bold">Penjualan</h1>
                    <p class="text-sm text-gray-500">Data Penjualan</p>
                </div>
            </div>
        </div>
        {{-- COPYRIGHT --}}
        <div class="pt-10 pb-5">
            <p class="text-center text-sm text-gray-500">Copyright &copy;2025, <span class="text-pink-primary">Qiyana Bouquet</span> All Right Reserved</p>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let options = {
            series: [{
                name: "STOCK ABC",
                data: [650, 1828, 1224, 1230, 2091]
            }],
            chart: {
                type: 'area',
                height: 350,
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            fill: {
                colors: ['#E64376']
            },
            labels: [
                '20-5-2025', '21-5-2025', '22-5-2025', '23-5-2025', '24-5-2025'
            ],
            legend: {
                horizontalAlign: 'left'
            }
        };

        let chart = new ApexCharts(document.querySelector("#line-chart"), options);

        chart.render();
    </script>
@endpush
