<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use RealRashid\SweetAlert\Facades\Alert;

class FrontendController extends Controller
{
    /**
     * 
     * FRONTEND TEST
     * 
     */
    public function test()
    {
        return view('test');
    }

    /**
     * 
     * FRONTEND INDEX
     * 
     */
    public function index()
    {
        $categories = ProductCategory::get();
        $products = Product::limit(12)->get();
        $allProducts = Product::get();
        $soldProduct = Transaction::sum('quantity');
        $customer = Customer::count();

        return view('index', compact('categories', 'products', 'soldProduct', 'customer', 'allProducts'));
    }

    /**
     * 
     * STORE ORDER
     * 
     */
    public function storeOrder(Request $request)
    {
        $rules = [];

        if ($request->customer_type == 'new_cust') {
            $rules = [
                'full_name' => 'required',
                'email' => 'required|email|unique:customers,email',
                'whatsapp' => 'required',
                'address' => 'required',
                'order_type' => 'required'
            ];
        } else {
            $rules = [
                'old_whatsapp' => 'required',
                'order_type' => 'required'
            ];
        }

        if ($request->order_type == 'cod') {
            $rules['cod_address'] = 'required';
        }

        $request->validate($rules);

        $product = Product::where('id', $request->product_id)->first();
        $oldCustomer = Customer::where('phone', preg_replace('/^0/', '62', $request->whatsapp ?? $request->old_whatsapp))->first();

        $newCustomer = '';

        if ($request->customer_type == 'new_cust') {
            $newCustomer = Customer::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => preg_replace('/^0/', '62', $request->whatsapp),
                'address' => $request->address
            ]);

        }

        Transaction::create([
            'customer_id' => $request->customer_type == 'new_cust' ? $newCustomer->id : $oldCustomer->id,
            'product_id' => $product->id,
            'quantity' => $request->qty,
            'total_price' => $request->qty,
            'status' => 'pending',
            'transaction_date' => now(),
            'transaction_type' => $request->order_type,
            'cod_address' => $request->order_type == 'cod' ? $request->cod_address : null
        ]);

        Product::where('id', $request->product_id)->update([
            'stock' => $product->stock - $request->qty
        ]);
        
        Alert::success('Berhasil!', 'Berhasil membuat pesanan')
            ->timerProgressBar()
            ->autoClose(3000);

        return redirect()->route('frontend.index');
    }

    /**
     * 
     * UPDATE ORDER STATUS
     * 
     */
    public function updateOrderStatus(Request $request)
    {
        $transaction = Transaction::where('id', $request->transaction_id)->first();

        $transaction->update([
            'status' => $request->status,
        ]);

        Alert::success('Berhasil!', 'Status transaksi berhasil diubah!')
            ->timerProgressBar()
            ->autoClose(3000);

        return redirect()->route('transaksi.index');
    }
}
