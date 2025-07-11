<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * 
     * ADMIN INDEX
     * 
     */
    public function index()
    {
        $productCount = Product::count();
        $transactionCount = Transaction::count();

        return view('admin.index', compact('productCount', 'transactionCount'));
    }

    /**
     * 
     * ADMIN EDIT PROFILE
     * 
     */
    public function editProfile()
    {
        $user = Auth::user();
        
        return view('admin.edit-profile', compact('user'));
    }
}
