<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Test</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>

        <iconify-icon icon="material-symbols:deployed-code-update-outline" width="20" height="20"></iconify-icon>

        if ($row->status == 'pending') {
            $dataToShow = '<span class="text-[10px] uppercase text-orange-700 bg-orange-500 bg-opacity-30 rounded-full px-4 py-1">Menunggu Pembayaran</span>';
        } else if ($row->status == 'paid') {
            $dataToShow = '<span class="text-[10px] uppercase text-green-700 bg-green-500 bg-opacity-30 rounded-full px-4 py-1">Pembayaran Lunas</span>';
        } else if ($row->status == 'canceled') {
            $dataToShow = '<span class="text-[10px] uppercase text-red-700 bg-red-500 bg-opacity-30 rounded-full px-4 py-1">Transaksi Dibatalkan</span>';
        } else if ($row->status == 'completed') {
            $dataToShow = '<span class="text-[10px] uppercase text-blue-700 bg-blue-500 bg-opacity-30 rounded-full px-4 py-1">Transaksi Selesai</span>';
        }
        <a target="_blank" href="https://wa.me/' . $row->whatsapp . '" class="flex items-center space-x-1 hover:underline text-green-500">
            <iconify-icon icon="logos:whatsapp-icon" width="14" height="14"></iconify-icon>
            <span>Link : ' . $row->whatsapp . '</span>
        </a>
        <div class="flex items-center space-x-2">
            <a href="/dashboard/kategori-produk/' . Crypt::encryptString($row->id) . '/edit" class="w-7 h-7 rounded-full flex justify-center items-center text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-300">
                <iconify-icon icon="material-symbols:edit-outline-rounded"></iconify-icon>
            </a>
            <div x-cloak x-data="{ show'. $row->id .': false }" class="flex items-center">
                <button x-on:click.prevent="show'. $row->id .' = true" class="w-7 h-7 rounded-full flex justify-center items-center text-white bg-red-500 hover:bg-red-600 focus:ring-2 focus:ring-red-300">
                    <iconify-icon icon="material-symbols:delete-outline"></iconify-icon>
                </button>
                <div x-show="show'. $row->id .'" class="w-full fixed inset-0 z-50 overflow-y-auto py-8 px-4">
                    <div x-show="show'. $row->id .'" class="w-full fixed inset-0 transform bg-gray-900 opacity-50 backdrop-blur-xl" x-on:click="show'. $row->id .' = false""></div>
                    <div x-show="show'. $row->id .'" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl p-6 md:p-8 transform transition-all w-full sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl mx-auto" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div class="text-gray-700">
                            <h1 class="text-lg font-bold">Hapus data?</h1>
                            <p class="text-sm whitespace-normal mt-1">Data '. $row->nama .' akan dihapus secara permanen</p>
                        </div>
                        <div class="flex justify-end mt-7 space-x-3">       
                            <button x-on:click="show'. $row->id .' = false" class="flex justify-center items-center rounded-sm w-28 h-9 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-red-700 transition-all duration-200 border border-red-300 bg-white hover:bg-red-100 text-red-500">
                                <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                <span class="font-semibold text-xs uppercase ml-1">Batalkan</span>
                            </button>
                            <form action="/dashboard/kategori-produk/' . $row->id . '" method="POST">
                                ' . method_field('DELETE') . '
                                '. csrf_field() .'
                                <button type="submit" class="flex justify-center items-center rounded-sm w-28 h-9 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-red-700 transition-all duration-200 bg-red-500 hover:bg-red-600 text-white">
                                    <iconify-icon icon="material-symbols:delete-outline"></iconify-icon>
                                    <span class="font-semibold text-xs uppercase ml-1">Hapus</span>
                                </button>
                            </form>             
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
