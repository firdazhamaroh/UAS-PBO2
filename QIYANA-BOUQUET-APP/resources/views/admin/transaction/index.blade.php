@extends('layouts.dashboard')

@section('title', 'Transaksi')

@push('styles')
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
@endpush

@section('content')
        <div class="w-full space-y-5 xl:space-y-10">
            {{-- TOP INFO --}}
            <div class="w-full grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-10">
                {{-- LEFT --}}
                <div class="w-full xl:col-span-2 bg-white rounded-lg p-5 py-10 lg:px-10">
                    <div class="w-full flex justify-between items-center">
                        <h1 class="flex text-2xl font-bold leading-normal xl:leading-relaxed">Data Transaksi</h1>
                    </div>
                    {{-- MAIN TABLE --}}
                    <table id="manajemen-pelanggan-datatable" class="w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer</th>
                                <th>Jumlah</th>
                                <th>Status Transaksi</th>
                                <th>Transaksi Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                {{-- RIGHT --}}
                <div class="w-full flex flex-col space-y-5 lg:space-y-10">
                    {{-- TOP --}}
                    <div class="w-full flex items-center space-x-2 lg:space-x-5 bg-white rounded-lg p-5 lg:p-8">
                        <div class="w-20 min-w-20 h-20 flex justify-center items-center bg-pink-primary bg-opacity-30 text-pink-primary rounded-full">
                            <iconify-icon icon="uil:transaction" width="32" height="32"></iconify-icon>
                        </div>
                        <div class="w-full">
                            <h1 class="text-xl md:text-2xl lg:text-3xl font-bold">{{ $transactionCount }}</h1>
                            <p class="text-sm text-gray-500">Total Transaksi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('script')
    {{-- JQUERY--}}
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    {{-- DATATABLES --}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    {{-- LOCAL SCRIPT --}}
    <script>
        $(function () {
            let PELANGGAN_DATATABLE = $('#manajemen-pelanggan-datatable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                autoWidth: false,
                aaSorting: [],
                ajax: {
                    url: "{{ route('transaksi.index') }}",
                    data: function(d) {
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex', 
                        name: 'DT_RowIndex',
                        orderable: false, 
                        searchable: false
                    },
                    {
                        data: 'customer', 
                        name: 'customer',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'quantity', 
                        name: 'quantity',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'transaction_status', 
                        name: 'transaction_status',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'transaction_date', 
                        name: 'transaction_date',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'aksi', 
                        name: 'aksi',
                        orderable: false,
                        searchable: true
                    }
                ]
            })
            .columns.adjust()
            .responsive.recalc();
        });
    </script>
@endpush