<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductCategory::orderBy('id', 'DESC');

            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                            $nama = $request->get('search');
                            
                            $w->orWhere('name', 'LIKE', "%$nama%");
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('nama_kategori', function($row) {
                    $dataToShow = '
                        <span class="font-medium">' . $row->name . '</span>
                    ';

                    return $dataToShow;
                })
                ->addColumn('aksi', function($row) {
                    return '<div class="flex items-center space-x-2">
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
                    </div>';
                })
                ->rawColumns(['nama_kategori', 'aksi'])
                ->make(true);
        }

        $productCategoryCount = ProductCategory::count();
        
        return view('admin.product-category.index', compact('productCategoryCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategoryCount = ProductCategory::count();

        return view('admin.product-category.create', compact('productCategoryCount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'category_name' => 'required|unique:product_categories,name|max:255',
        ]);

        ProductCategory::create([
            'name' => $validated['category_name'],
        ]);

        Alert::success('Berhasil!', 'Kategori berhasil ditambah!')
            ->timerProgressBar()
            ->autoClose(3000);
        return redirect()->route('kategori-produk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $productCategoryCount = ProductCategory::count();
        $productCategory = ProductCategory::where('id', Crypt::decryptString($id))->first();

        return view('admin.product-category.edit', compact('productCategoryCount', 'productCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);
    
        $category = ProductCategory::findOrFail($id);
    
        // Cek jika nama kategori sudah digunakan kategori lain
        $duplicate = ProductCategory::where('name', $request->category_name)
                        ->where('id', '!=', $id)
                        ->exists();
    
        if ($duplicate) {
            Alert::error('Gagal', 'Nama kategori sudah digunakan!');
            return redirect()->back()->withInput();
        }
    
        // Update nama kategori
        $category->update([
            'name' => $request->category_name,
        ]);
    
        Alert::success('Berhasil', 'Kategori produk berhasil diperbarui')
            ->timerProgressBar()
            ->autoClose(3000);
        return redirect()->route('kategori-produk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $productCategory = productCategory::find($id);

        $productCategory->delete();

        Alert::success('Berhasil!', 'Berhasil menghapus Kategori')
            ->timerProgressBar()
            ->autoClose(3000);

        return redirect()->route('kategori-produk.index');
    }
}
