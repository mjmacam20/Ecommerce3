<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrdersProduct;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderItemStatus;
use App\Models\User;
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
    public function orderDetails($id){
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if($adminType=="vendor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','Your Vendor Account is not approved yet. Please make sure to fill your valid personal, business, and bank details.');
            }
        }

        if($adminType=="vendor"){
            $orderDetails = Order::with(['orders_products'=>function($query)use($vendor_id){
                $query->where('vendor_id',$vendor_id);
            }])->where('id',$id)->first()->toArray();
        }else{
            $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        }

       
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
        $orderStatuses = OrderStatus::where('status',1)->get()->toArray();
        $orderItemStatuses = OrderItemStatus::where('status',1)->get()->toArray();
        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatuses','orderItemStatuses'));
    }

    public function updateOrderStatus(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            //Update Order Status
            Order::where('id', $data['order_id'])->update(['order_status'=>$data['order_status']]);
            $message = "Order Status has been updated Successfully!";
            return redirect()->back()->with('success_message',$message);
        }
    }

    public function updateOrderItemStatus(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            //Update Order Status
            OrdersProduct::where('id', $data['order_item_id'])->update(['item_status'=>$data['order_item_status']]);
            $message = "Order Item Status has been updated Successfully!";
            return redirect()->back()->with('success_message',$message);
        }
    }
}
