<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    
    if ($request->ajax()) {
        $data = Discount::with('product')->orderBy('start_date', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_produk', function ($row) {
                return '<span class="font-medium">' . $row->product->product_name . '</span>';
            })
            ->addColumn('persentase', function ($row) {
                return $row->percentage . '%';
            })
            ->addColumn('tanggal_awal', function ($row) {
                return \Carbon\Carbon::parse($row->start_date)->translatedFormat('d M Y');
            })
            ->addColumn('tanggal_akhir', function ($row) {
                return \Carbon\Carbon::parse($row->end_date)->translatedFormat('d M Y');
            })
            ->addColumn('aksi', function ($row) {
                $id = Crypt::encryptString($row->id);
                return '<div class="flex items-center space-x-2">
                    <a href="'. route('diskon.edit', $id) .'" class="w-7 h-7 rounded-full flex justify-center items-center text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-300">
                        <iconify-icon icon="material-symbols:edit-outline-rounded"></iconify-icon>
                    </a>
                    <div x-cloak x-data="{ show' . $row->id . ': false }" class="flex items-center">
                        <button x-on:click.prevent="show' . $row->id . ' = true" class="w-7 h-7 rounded-full flex justify-center items-center text-white bg-red-500 hover:bg-red-600 focus:ring-2 focus:ring-red-300">
                            <iconify-icon icon="material-symbols:delete-outline"></iconify-icon>
                        </button>
                        <div x-show="show' . $row->id . '" class="w-full fixed inset-0 z-50 overflow-y-auto py-8 px-4">
                            <div x-show="show' . $row->id . '" class="w-full fixed inset-0 transform bg-gray-900 opacity-50 backdrop-blur-xl" x-on:click="show' . $row->id . ' = false"></div>
                            <div x-show="show' . $row->id . '" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl p-6 md:p-8 transform transition-all w-full sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl mx-auto"
                                x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave="ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                <div class="text-gray-700">
                                    <h1 class="text-lg font-bold">Hapus data?</h1>
                                    <p class="text-sm whitespace-normal mt-1">Diskon untuk produk <strong>' . $row->product->name . '</strong> akan dihapus secara permanen.</p>
                                </div>
                                <div class="flex justify-end mt-7 space-x-3">       
                                    <button x-on:click="show' . $row->id . ' = false" class="flex justify-center items-center rounded-sm w-28 h-9 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-red-700 transition-all duration-200 border border-red-300 bg-white hover:bg-red-100 text-red-500">
                                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                        <span class="font-semibold text-xs uppercase ml-1">Batalkan</span>
                                    </button>
                                    <form action="' . route('diskon.destroy', $row->id) . '" method="POST">
                                        ' . method_field('DELETE') . '
                                        ' . csrf_field() . '
                                        <button type="submit" class="flex justify-center items-center rounded-sm w-28 h-9 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-red-700 transition-all duration-200 bg-red-500 hover:bg-red-600 text-white">
                                            <iconify-icon icon="material-symbols:delete-outline"></iconify-icon>
                                            <span class="font-semibold text-xs uppercase ml-1">Hapus</span>
                                        </button>
                                    </form>             
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            })
            
            ->rawColumns(['nama_produk', 'aksi'])
            ->make(true);
    }

    $discountCount = Discount::count();


    return view('admin.discount.index', compact('discountCount'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::all(); // Menampilkan semua produk untuk dipilih
        return view('admin.discount.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    
        // Cek apakah produk sudah memiliki diskon aktif di tanggal tersebut
        $existing = Discount::where('product_id', $request->product_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            })->first();
    
        if ($existing) {
            Alert::error('Gagal', 'Produk ini sudah memiliki diskon aktif pada rentang tanggal tersebut.');
            return redirect()->back()->withInput();
        }
    
        Discount::create([
            'product_id' => $request->product_id,
            'percentage' => $request->percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    
        Alert::success('Berhasil', 'Diskon berhasil ditambahkan!');
        return redirect()->route('diskon.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $id = Crypt::decryptString($id);
    $discount = Discount::findOrFail($id);
    $discount->start_date = Carbon::parse($discount->start_date);
    $discount->end_date = Carbon::parse($discount->end_date);
    $products = Product::all();

    return view('admin.discount.edit', compact('discount', 'products'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $discount = Discount::findOrFail($id);

    // Validasi input
    $request->validate([
        'product_id'   => 'required|exists:products,id',
        'percentage'   => 'required|numeric|min:0|max:100',
        'start_date'   => 'required|date',
        'end_date'     => 'required|date|after_or_equal:start_date',
    ]);

    // Cek apakah produk sudah memiliki diskon aktif di tanggal tersebut
    $existing = Discount::where('product_id', $request->product_id)
        ->where('id', '!=', $discount->id) // pengecualian untuk data yang sedang di-update
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
        })->first();

    if ($existing) {
        Alert::error('Gagal', 'Produk ini sudah memiliki diskon aktif pada rentang tanggal tersebut.');
        return redirect()->back()->withInput();
    }

    // Update data
    $discount->update([
        'product_id'  => $request->product_id,
        'percentage'  => $request->percentage,
        'start_date'  => $request->start_date,
        'end_date'    => $request->end_date,
    ]);

    Alert::success('Berhasil', 'Diskon berhasil diperbarui!');
    return redirect()->route('diskon.index');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $discount = discount::find($id);

        $discount->delete();

        Alert::success('Berhasil!', 'Berhasil menghapus Diskon')
            ->timerProgressBar()
            ->autoClose(3000);

        return redirect()->route('diskon.index');
    }
}
