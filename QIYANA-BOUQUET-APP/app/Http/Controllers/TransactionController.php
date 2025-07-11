<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::orderBy('id', 'DESC');

            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $nama = $request->get('search');

                            $w->orWhere('customer', 'LIKE', "%$nama%");
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('customer', function ($row) {
                    $dataToShow = '
                        <div class="flex flex-col">
                            <h1 class="font-semibold">' . $row->customer->full_name . '</h1>
                            <span class="text-xs">' . $row->product->product_name . '</span>
                        </div>
                    ';

                    return $dataToShow;
                })
                ->addColumn('quantity', function ($row) {
                    return $row->quantity . ' - ' . '(Rp. ' . number_format($row->total_price, 0, '.', ',') . ')';
                })
                ->addColumn('transaction_status', function ($row) {
                    $dataToShow = '';
                    
                    if ($row->status == 'pending') {
                        $dataToShow = '<span class="text-[10px] uppercase text-orange-700 bg-orange-500 bg-opacity-30 rounded-full px-4 py-1">Menunggu Pembayaran</span>';
                    } else if ($row->status == 'paid') {
                        $dataToShow = '<span class="text-[10px] uppercase text-green-700 bg-green-500 bg-opacity-30 rounded-full px-4 py-1">Pembayaran Lunas</span>';
                    } else if ($row->status == 'canceled') {
                        $dataToShow = '<span class="text-[10px] uppercase text-red-700 bg-red-500 bg-opacity-30 rounded-full px-4 py-1">Transaksi Dibatalkan</span>';
                    } else if ($row->status == 'completed') {
                        $dataToShow = '<span class="text-[10px] uppercase text-blue-700 bg-blue-500 bg-opacity-30 rounded-full px-4 py-1">Transaksi Selesai</span>';
                    }

                    return $dataToShow;
                })
                ->addColumn('transaction_date', function ($row) {
                    return Carbon::parse($row->transaction_date)->translatedFormat('d M Y');
                })
                ->addColumn('aksi', function ($row) {
                    return '<div class="flex items-center space-x-2 mt-3 lg:mt-0">
                        <div x-cloak x-data="{ showUpdateTransaction' . $row->id . ': false }" class="flex items-center">
                            <button x-on:click.prevent="showUpdateTransaction' . $row->id . ' = true" class="w-7 h-7 rounded-full flex justify-center items-center text-white bg-green-500 hover:bg-green-600 focus:ring-2 focus:ring-green-300">
                                <iconify-icon icon="material-symbols:deployed-code-update-outline" width="16" height="16"></iconify-icon>
                            </button>
                            <div x-show="showUpdateTransaction' . $row->id . '" class="w-full fixed inset-0 z-50 overflow-y-auto py-8 px-4">
                                <div x-show="showUpdateTransaction' . $row->id . '" class="w-full fixed inset-0 transform bg-gray-900 opacity-50 backdrop-blur-xl" x-on:click="showUpdateTransaction' . $row->id . ' = false""></div>
                                <form action="/update-transaction?transaction_id=' . $row->id . '" x-show="showUpdateTransaction' . $row->id . '" method="POST" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl p-6 md:p-8 transform transition-all w-full sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl mx-auto" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                    ' . csrf_field() . '
                                    <div class="text-gray-700">
                                        <h1 class="text-lg font-bold">Update Transaksi</h1>
                                        <p class="text-sm whitespace-normal mt-1">Update status transaksi pelanggan Anda</p>
                                    </div>
                                    <div class="w-full mt-5">
                                        <select name="status" class="w-full text-sm transition-all duration-300 border-gray-300 focus:border-pink-primary ring-transparent focus:ring-transparent rounded-lg">
                                            <option selected disabled>--Pilih status pesanan</option>
                                            <option value="paid">Sudah dibayar</option>
                                            <option value="canceled">Dibatalkan</option>
                                            <option value="completed">Selesai</option>
                                        </select>
                                    </div>
                                    <div class="flex justify-end mt-7 space-x-3">       
                                        <button x-on:click.prevent="showUpdateTransaction' . $row->id . ' = false" class="flex justify-center items-center rounded-sm w-28 h-9 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-red-700 transition-all duration-200 border border-red-300 bg-white hover:bg-red-100 text-red-500">
                                            <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                            <span class="font-semibold text-xs uppercase ml-1">Batalkan</span>
                                        </button>        
                                        <button type="submit" class="flex justify-center items-center rounded-sm w-28 h-9 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-green-700 transition-all duration-200 bg-green-500 hover:bg-green-600 text-white">
                                            <iconify-icon icon="material-symbols:deployed-code-update-outline" width="16" height="16"></iconify-icon>
                                            <span class="font-semibold text-xs uppercase ml-1">Update</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>';
                })
                ->rawColumns(['customer', 'quantity', 'transaction_status', 'transaction_date', 'aksi'])
                ->make(true);
        }
        
        $transactionCount = Transaction::count();

        return view('admin.transaction.index', compact('transactionCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
