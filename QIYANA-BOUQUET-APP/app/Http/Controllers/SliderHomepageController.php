<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SliderHomepage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SliderHomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SliderHomepage::orderBy('id', 'DESC');

            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $nama = $request->get('search');

                            $w->orWhere('title', 'LIKE', "%$nama%");
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $dataToShow = '
                        <div class="w-10 h-10 rounded-full overflow-hidden">
                            <img src="/storage/' . $row->image . '" class="w-full h-full object-cover " />
                        </div>
                    ';

                    return $dataToShow;
                })
                ->addColumn('title', function ($row) {
                    $dataToShow = '
                        <div class="flex flex-col">
                            <h1 class="font-semibold w-64 md:w-96 truncate overflow-ellipsis">' . $row->title . '</h1>
                            <span>Sub Judul : ' . $row->subtitle . '</span>
                        </div>
                    ';

                    return $dataToShow;
                })
                ->addColumn('description', function ($row) {
                    return $row->description;
                })
                ->addColumn('link', function ($row) {
                    $dataToShow = '
                        <div class="flex flex-col">
                            <h1 class="font-semibold w-64 md:w-96 truncate overflow-ellipsis">' . $row->link_text . '</h1>
                            <span>Link : ' . $row->link . '</span>
                        </div>
                    ';

                    return $dataToShow;
                })
                ->addColumn('aksi', function ($row) {
                    return '<div class="flex items-center space-x-2 mt-3 lg:mt-0">
                        <a href="/dashboard/slider-homepage/' . Crypt::encryptString($row->id) . '/edit" class="w-7 h-7 rounded-full flex justify-center items-center text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-300">
                            <iconify-icon icon="material-symbols:edit-outline-rounded"></iconify-icon>
                        </a>
                        <div x-cloak x-data="{ show' . $row->id . ': false }" class="flex items-center">
                            <button x-on:click.prevent="show' . $row->id . ' = true" class="w-7 h-7 rounded-full flex justify-center items-center text-white bg-red-500 hover:bg-red-600 focus:ring-2 focus:ring-red-300">
                                <iconify-icon icon="material-symbols:delete-outline"></iconify-icon>
                            </button>
                            <div x-show="show' . $row->id . '" class="w-full fixed inset-0 z-50 overflow-y-auto py-8 px-4">
                                <div x-show="show' . $row->id . '" class="w-full fixed inset-0 transform bg-gray-900 opacity-50 backdrop-blur-xl" x-on:click="show' . $row->id . ' = false""></div>
                                <div x-show="show' . $row->id . '" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl p-6 md:p-8 transform transition-all w-full sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl mx-auto" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                    <div class="text-gray-700">
                                        <h1 class="text-lg font-bold">Hapus data?</h1>
                                        <p class="text-sm whitespace-normal mt-1">Data ' . $row->title . ' akan dihapus secara permanen</p>
                                    </div>
                                    <div class="flex justify-end mt-7 space-x-3">       
                                        <button x-on:click="show' . $row->id . ' = false" class="flex justify-center items-center rounded-sm w-28 h-9 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-red-700 transition-all duration-200 border border-red-300 bg-white hover:bg-red-100 text-red-500">
                                            <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                            <span class="font-semibold text-xs uppercase ml-1">Batalkan</span>
                                        </button>
                                        <form action="/dashboard/slider-homepage/' . $row->id . '" method="POST">
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
                ->rawColumns(['image', 'title', 'description', 'link', 'aksi'])
                ->make(true);
        }
        
        $sliderHomepageCount = SliderHomepage::count();

        return view('admin.slider-homepage.index', compact('sliderHomepageCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $sliderHomepageCount = SliderHomepage::count();
        return view('admin.slider-homepage.create',compact('sliderHomepageCount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'judul_slide' => 'required|unique:slider_homepages,title',
        'subjudul_slide' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'link' => 'required|url|unique:slider_homepages,link',
        'link_text' => 'required',
        'deskripsi' => 'required'
    ]);

    // Tambahan validasi manual untuk kombinasi judul + subjudul
    $exists = SliderHomepage::where('title', $request->judul_slide)
                ->where('subtitle', $request->subjudul_slide)
                ->exists();

    if ($exists) {
        return back()->withErrors([
            'judul_slide' => 'Kombinasi Judul dan Subjudul ini sudah digunakan.',
        ])->withInput();
    }

    // Simpan gambar ke penyimpanan
    $imagePath = $request->file('image')->store('slider-homepage', 'public');

    // Simpan data
    SliderHomepage::create([
        'image' => $imagePath,
        'title' => $request->judul_slide,
        'subtitle' => $request->subjudul_slide,
        'link' => $request->link,
        'link_text' => $request->link_text,
        'description' => $request->deskripsi,
    ]);

    Alert::success('Berhasil!', 'Slide Berhasil Ditambahkan!')
        ->timerProgressBar()
        ->autoClose(3000);

    return redirect()->route('slider-homepage.index');
}


    /**
     * Display the specified resource.
     */
    public function show(SliderHomepage $sliderHomepage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sliderHomepageCount = SliderHomepage::count();
        $sliderHomepage = SliderHomepage::where('id', Crypt::decryptString($id))->first();
        

        return view('admin.slider-homepage.edit', compact('sliderHomepageCount', 'sliderHomepage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $decryptedId = Crypt::decrypt($id);
    $slider = SliderHomepage::findOrFail($decryptedId);

    $request->validate([
        'judul_slide' => 'required|unique:slider_homepages,title,' . $decryptedId,
        'subjudul_slide' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'link' => 'required|url|unique:slider_homepages,link,' . $decryptedId,
        'link_text' => 'required',
        'deskripsi' => 'required'
    ]);

    if ($request->hasFile('image')) {
        // Hapus gambar lama
        $oldPath = public_path('storage/' . $slider->image);
        if (File::exists($oldPath)) {
            File::delete($oldPath);
        }

        // Simpan gambar baru
        $slider->image = $request->file('image')->store('slider-homepage', 'public');
    }

    // Update data lainnya
    $slider->update([
        'title' => $request->judul_slide,
        'subtitle' => $request->subjudul_slide,
        'link' => $request->link,
        'link_text' => $request->link_text,
        'description' => $request->deskripsi,
        'image' => $slider->image // pastikan tetap menyimpan jika gambar tidak diubah
    ]);

    Alert::success('Berhasil!', 'Slide berhasil diperbarui!')
        ->timerProgressBar()
        ->autoClose(3000);

    return redirect()->route('slider-homepage.index');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $slider = SliderHomepage::findOrFail($id); // pakai langsung ID biasa

    $imagePath = public_path('storage/slider-homepage/' . $slider->image);
    if (File::exists($imagePath)) {
        File::delete($imagePath);
    }

    $slider->delete();

    Alert::success('Berhasil!', 'Berhasil menghapus slide Homepage!')
        ->timerProgressBar()
        ->autoClose(3000);

    return redirect()->route('slider-homepage.index');
}
}
