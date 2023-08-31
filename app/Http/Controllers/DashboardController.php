<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function DashboardPage(){
        return view('pages.dashboard.dashboard-page');
    }

    function Summary(Request $request){
        $user_id = $request->header('id');
        $product = Product::where('user_id', $user_id)->count();
        $category = Category::where('user_id', $user_id)->count();
        $customer = Customer::where('user_id', $user_id)->count();
        $Invoice = Invoice::where('user_id', $user_id)->count();
        $total = Invoice::where('user_id', $user_id)->sum('total');
        $payable = Invoice::where('user_id', $user_id)->sum('payable');
        $vat = Invoice::where('user_id', $user_id)->sum('vat');
        $discount = Invoice::where('user_id', $user_id)->sum('discount');

        return[
            'product'=> $product,
            'category'=> $category,
            'customer'=> $customer,
            'invoice'=> $Invoice,
            'total'=> round($total,2),
            'vat'=> round($vat,2),
            'payable'=> round($payable,2),
            'discount'=> round($discount,2),
        ];
    }
}
