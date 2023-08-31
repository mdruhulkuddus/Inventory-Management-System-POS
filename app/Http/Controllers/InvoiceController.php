<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    function InvoicePage()
    {
        return view('pages.dashboard.invoice-page');
    }

    function SalePage()
    {
        return view('pages.dashboard.sale-page');
    }

    function invoiceCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');
            $customerID = $request->input('customer_id');
            $invoice = Invoice::create([
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'payable' => $payable,
                'user_id'=>$user_id,
                'customer_id' => $customerID
            ]);

            $invoiceID = $invoice->id;
            $products = $request->input('products');

            foreach ($products as $product) {
                InvoiceProduct::create([
                    'invoice_id' => $invoiceID,
                    'user_id' => $user_id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'sale_price' => $product['sale_price'],
                ]);
            }
            DB::commit();
            return 1;
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }

    function invoiceSelect(Request $request){
        $user_id = $request->header('id');
        return Invoice::where('user_id', $user_id)->with('customer')->get();
    }

//    function InvoiceDetails(Request $request){
//        $user_id=$request->header('id');
////        return Customer::where('user_id',$user_id)->where('id',$request->input('cus_id'))->first();
////        return Invoice::where('user_id','=',$user_id)->where('id',$request->input('inv_id'))->first();
//        return InvoiceProduct::where('invoice_id',$request->input('inv_id'))
//            ->where('user_id',$user_id)->with('product')
//            ->get();
////        return [
////            'customer'=>$customerDetails,
////            'invoice'=>$invoiceTotal,
////            'product'=>$invoiceProduct,
////        ];
//    }

    function invoiceDetails(Request $request){

        $user_id = $request->header('id');

        $customerDetails = Customer::where('user_id', $user_id)->where('id', $request->input('cus_id'))->first();
        $invoiceTotal = Invoice::where('user_id', $user_id)->where('id', $request->input('inv_id'))->first();
        $invoiceProduct = InvoiceProduct::where('invoice_id', $request->input('inv_id'))
            ->where('user_id', $user_id)->with('product')->get();

        return array(
            'customer' => $customerDetails,
            'invoice' => $invoiceTotal,
            'product' => $invoiceProduct
        );
    }

    function invoiceDelete(Request $request){
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            InvoiceProduct::where('invoice_id', $request->input('inv_id'))
                ->where('user_id', $user_id)->with('product')->delete();
            Invoice::where('id', $request->input('inv_id'))->delete();
            DB::commit();
            return 1;
        }catch(Exception $e){
            DB::rollBack();
            return 0;
        }
    }
}
