<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    public function orders(){
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if($adminType=="vendor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','Your Vendor Account is not approved yet. Please make sure to fill your valid personal, business, and bank details.');
            }
        }
        if($adminType=="vendor"){
            $orders = Order::with(['orders_products'=>function($query)use($vendor_id){
                $query->where('vendor_id',$vendor_id);
            }])->orderBy('id','Desc')->get()->toArray();
        }else{
            $orders = Order::with('orders_products')->orderBy('id','Desc')->get()->toArray();
        }
      
        /*dd($orders);*/
        return view('admin.orders.orders')->with(compact('orders'));
    }
}
