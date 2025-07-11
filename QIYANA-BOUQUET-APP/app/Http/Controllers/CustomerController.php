<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::orderBy('id', 'DESC');

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
                ->addColumn('full_name', function ($row) {
                    $dataToShow = '
                        <div class="flex flex-col">
                            <h1 class="font-semibold">' . $row->full_name . '</h1>
                            <span class="text-xs">' . $row->email . '</span>
                        </div>
                    ';

                    return $dataToShow;
                })
                ->addColumn('email', function ($row) {
                    return $row->email;
                })
                ->addColumn('whatsapp', function ($row) {
                    $dataToShow = '
                        <a target="_blank" href="https://wa.me/' . $row->whatsapp . '" class="flex items-center space-x-1 hover:underline text-green-500">
                            <iconify-icon icon="logos:whatsapp-icon" width="14" height="14"></iconify-icon>
                            <span>' . $row->phone . '</span>
                        </a>
                    ';

                    return $dataToShow;
                })
                ->addColumn('address', function ($row) {
                    return $row->address;
                })
                ->rawColumns(['full_name', 'whatsapp'])
                ->make(true);
        }
        
        $customerCount = Customer::count();

        return view('admin.customer.index', compact('customerCount'));
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
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
