@extends('layouts.dashboard')

@section('title', 'Diskon Produk')

@push('styles')
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="w-full space-y-5 xl:space-y-10">
        <div class="w-full grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-10">
            {{-- LEFT --}}
            <div class="w-full xl:col-span-2 bg-white rounded-lg p-5 py-10 lg:px-10">
                <div class="w-full flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Diskon Produk</h1>
                    <a href="{{ route('diskon.create') }}">
                        <x-primary-button class="w-40">Tambah Diskon</x-primary-button>
                    </a>
                </div>

                <table id="diskon-datatable" class="w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Persentase</th>
                            <th>Tanggal Awal</th>
                            <th>Tanggal Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            {{-- RIGHT --}}
            <div class="w-full flex flex-col space-y-5 lg:space-y-10">
                <div class="w-full flex items-center space-x-2 lg:space-x-5 bg-white rounded-lg p-5 lg:p-8">
                    <div class="w-20 h-20 flex justify-center items-center bg-yellow-300 bg-opacity-50 text-yellow-500 rounded-full">
                        <iconify-icon icon="mdi:discount" width="30" height="30"></iconify-icon>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $discountCount }}</h1>
                        <p class="text-sm text-gray-500">Total Diskon Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- JQUERY --}}
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    {{-- DATATABLES --}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

    <script>
        $(function () {
            $('#diskon-datatable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('diskon.index') }}",
                    data: function (d) {
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama_produk', name: 'nama_produk' },
                    { data: 'persentase', name: 'persentase' },
                    { data: 'tanggal_awal', name: 'tanggal_awal' },
                    { data: 'tanggal_akhir', name: 'tanggal_akhir' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush
