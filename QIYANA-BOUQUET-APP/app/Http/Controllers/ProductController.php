<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::orderBy('id', 'DESC');

            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                            $nama = $request->get('search');
                            
                            $w->orWhere('product_name', 'LIKE', "%$nama%");
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('thumbnail', function($row) {
                    $dataToShow = '
                        <div class="w-10 h-10 rounded-full overflow-hidden">
                            <img src="/storage/' . $row->thumbnail . '" class="w-full h-full object-cover " />
                        </div>
                    ';

                    return $dataToShow;
                })
                ->addColumn('product_name', function($row) {
                    $dataToShow = '
                        <span class="font-medium">' . $row->product_name . '</span>
                    ';

                    return $dataToShow;
                })
                ->addColumn('aksi', function($row) {
                    return '<div class="flex items-center space-x-2">
                        <a href="/dashboard/produk/' . Crypt::encryptString($row->id) . '/edit" class="w-7 h-7 rounded-full flex justify-center items-center text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-300">
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
                                        <form action="/dashboard/produk/' . $row->id . '" method="POST">
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
                    </div>';
                })
                ->rawColumns(['thumbnail','product_name', 'aksi'])
                ->make(true);
        }

        $productCount = Product::count();
        
        return view('admin.product.index', compact('productCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCount = Product::count();
        $categories = ProductCategory::all();

        return view('admin.product.create', compact('productCount','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'product_name' => 'required|string|max:255|unique:products,product_name',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:live,archive',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Upload file thumbnail
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
    
        // Simpan data produk
        Product::create([
            'product_category_id' => $request->product_category_id,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status,
            'thumbnail' => $thumbnailPath,
        ]);
    
        Alert::success('Berhasil', 'Produk berhasil ditambahkan!');

        return redirect()->route('produk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $productCount = Product::count();
        $product = Product::where('id', Crypt::decryptString($id))->first();
        $categories = ProductCategory::all();

        return view('admin.product.edit', compact('productCount', 'product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'product_category_id' => 'required|exists:product_categories,id',
        'thumbnail' => 'nullable|image|max:2048',
        'product_name' => 'required|string|max:255|unique:products,product_name,' . $id,
        'description' => 'required',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'status' => 'required|in:live,archive',
    ]);

    $product = Product::findOrFail($id);

    $product->product_category_id = $request->product_category_id;
    $product->product_name = $request->product_name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->stock = $request->stock;
    $product->status = $request->status;

    if ($request->hasFile('thumbnail')) {
        // Hapus file lama jika perlu
        if ($product->thumbnail && file_exists(public_path('storage/' . $product->thumbnail))) {
            unlink(public_path('storage/' . $product->thumbnail));
        }

        $path = $request->file('thumbnail')->store('thumbnails', 'public');
        $product->thumbnail = $path;
    }

    $product->save();

    Alert::success('Berhasil', 'Produk berhasil diupdate!');

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $product = product::find($id);

        $product->delete();

        Alert::success('Berhasil!', 'Berhasil menghapus product')
            ->timerProgressBar()
            ->autoClose(3000);

        return redirect()->route('produk.index');
    }
}
