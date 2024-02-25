<?php

namespace App\Http\Controllers\Front;

use App\Models\DeliveryAddress;
use App\Models\OrdersProduct;
use App\Models\ProductsAttribute;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Category;
use App\Models\Country;
use Session;
use DB;
use Auth;

class ProductsController extends Controller
{
    public function listing(){
        //echo "test"; die;
        $url = Route::getFacadeRoot()->current()->uri(); 
        $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
        if($categoryCount>0){
            //Get Category Details
            $categoryDetails = Category::categoryDetails($url);
            $categoryProducts = Product::with('author')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
            
            //check for sort
            if(isset($_GET['sort']) && !empty($_GET['sort'])){
                if($_GET['sort']=="product_latest"){
                    $categoryProducts->orderby('products.id','Desc');
                }else if($_GET['sort']=="price_lowest"){
                    $categoryProducts->orderby('products.product_price','Asc');
                }else if($_GET['sort']=="price_highest"){
                    $categoryProducts->orderby('products.product_price','Desc');
                }else if($_GET['sort']=="name_z_a"){
                    $categoryProducts->orderby('products.product_name','Desc');
                }else if($_GET['sort']=="name_a_z"){
                    $categoryProducts->orderby('products.product_name','Asc');
                }
            }

            $categoryProducts = $categoryProducts->paginate(30);
            //dd($categoryProducts);
            //echo "Categories Exists"; die;
            return view ('front.products.listing')->with(compact('categoryDetails','categoryProducts'));
        }else{
            abort(404);
        }
    }

    public function vendorListing($vendorid){
        //Get Vendor Shop Name
       $getVendorShop = Vendor::getVendorShop($vendorid);
       // Get Vendor Products
       $vendorProducts = Product::with('author')->where('vendor_id',$vendorid)->where('status',1);
       $vendorProducts = $vendorProducts->paginate(30);
       return view('front.products.vendor_listing')->with(compact('getVendorShop','vendorProducts'));
    }
    public function detail($id){
        $productDetails = Product::with(['section','category','author','attributes'=>function($query){
            $query->where('stock','>',0)->where('status',1);
        },'images','vendor'])->find($id)->toArray();
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        //dd($productDetails);

        //get similar products
        $similarProducts = Product::with('author')->where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->limit(10)->inRandomOrder()->get()->toArray();
        //dd($similarProducts);

        // Set ka ng session sa recently viewed products
        if(empty(Session::get('session_id'))){
            $session_id = md5(uniqid(rand(), true));
        }else{
            $session_id = Session::get('session_id');
        }

        Session::put('session_id',$session_id);

        // Insert ka ng products sa table if not hindi pa nag eexists 
        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRecentlyViewedProducts==0){
            DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id]);
        }
        // Get Recently Viewed Products IDs
        $recentProductIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)->inRandomOrder()->get()->take(10)->pluck('product_id');

         // Get Recently Viewed Products
        $recentlyViewedProducts = Product::with('author')->whereIn('id', $recentProductIds)->get()->toArray();

        $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock'); 
        return view('front.products.detail')->with(compact('productDetails','categoryDetails','totalStock','similarProducts','recentlyViewedProducts'));
    }

    public function getProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['size']);
            return $getDiscountAttributePrice;
        }
    }

    public function cartAdd(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            // Check kung may avail pa na stock or wala.
            $getProductStock = ProductsAttribute::getProductStock($data['product_id'],$data['size']);
            if($getProductStock<$data['quantity']){
                return redirect()->back()->with('error_message','Required Quantity is not available!');
            }
                // Generate Session Id if not exists
                $session_id = Session::get('session_id');
                if(empty($session_id)){
                    $session_id = Session::getId();
                    Session::put('session_id',$session_id);
                }

            //Check products if already exists in the user cart
            if(Auth::check()){
                // User is logged in
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>$user_id])->count();
            }else{
                $user_id = 0;
                // User is not logged in
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>$session_id])->count();
            }

            if($countProducts>0){
                return redirect()->back()->with('error_message','Product already exists in Cart!');
                
            }

                // Generate Session id if not exists
                $session_id = Session::get('session_id');
                if(empty($session_id)){
                    $session_id = Session::getId();
                    Session::put('session_id',$session_id);
                }


            // Save Product in carts table
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();

            return redirect()->back()->with('success_message','Product has been added in Cart! <a style="text-decoration:underline !important" href="/cart">View Cart</a>');
        }
    }

    public function cart(){
        $getCartItems = Cart::getCartItems();
        //dd($getCartItems);
        return view('front.products.cart')->with(compact('getCartItems'));
    }

    public function cartUpdate(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            // Get Cart Details 
            $cartDetails = Cart::find($data['cartid']);
            // Get Available Product Stock
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();

            /*echo "<pre>"; print_r($availableStock); die;*/
            //Check if desired stock from user is available
            if($data['qty']>$availableStock['stock']){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Product Stock is not available',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }
            
            //Check if product size is available    
            $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size'],'status'=>1])->count();
            if($availableSize == 0){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Product Size is not available',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }

            // update quantity
            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    public function cartDelete(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            Cart::where('id',$data['cartid'])->delete();
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);
        }
    }
    

    public function checkout(Request $request){
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        $countries = Country::where('status',1)->get()->toArray();
        $getCartItems = Cart::getCartItems();
        //dd($getCartItems);

        if(count($getCartItems)==0){
            $message = "Cart is Empty! Please add products.";
            return redirect('cart')->with('error_message',$message);
        }

        if($request->isMethod('post')){
            $data = $request->all();
            

             // Delivery Address
             if(empty($data['address_id'])){
                $message = "Please select delivery address!";
                return redirect()->back()->with('error_message',$message);
             }
             // Payment Method Validation
             if(empty($data['payment_gateway'])){
                $message = "Please select Payment Method!";
                return redirect()->back()->with('error_message',$message);
             }
             // Agree Validation
             if(empty($data['accept'])){
                $message = "Please agree to Terms and Condition";
                return redirect()->back()->with('error_message',$message);
             }
             //echo "<pre>"; print_r($data); die;
            $deliveryAddress = DeliveryAddress::where('id',$data['address_id'])->first()->toArray();
            //dd($getdeliveryAddress);

            // Set Payment Method as COD if COD is selected from user otherwise set as Prepaid
            if($data['payment_gateway']=="COD"){
                $payment_method = "COD";
                $order_status = "New";
            }else{
                $payment_method = "Prepaid";
                $order_status = "Pending";
            }
            DB::beginTransaction();
                // Fetch Order Total Price
                $total_price = 0;
                foreach($getCartItems as $item){
                    $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                    $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']);
                }
                // Calculate shipping charges
                $shipping_charges = 0;

                // Calculate Grand Total
                $grand_total = $total_price + $shipping_charges;

                //Insert Grand Total
                Session::put('grand_total',$grand_total);

                //Insert Order Details
                $order = new Order;
                $order->user_id = Auth::user()->id;
                $order->name = $deliveryAddress['name'];
                $order->address = $deliveryAddress['address'];
                $order->city = $deliveryAddress['city'];
                $order->state = $deliveryAddress['state'];
                $order->country = $deliveryAddress['country'];
                $order->zipcode = $deliveryAddress['zipcode'];
                $order->mobile = $deliveryAddress['mobile'];
                $order->email = Auth::user()->email;
                $order->shipping_charges = $shipping_charges;
                $order->order_status = $order_status;
                $order->payment_method = $payment_method;
                $order->payment_gateway = $data['payment_gateway'];
                $order->grand_total = $grand_total;
                $order->save();
                $order_id = DB::getPdo()->lastInsertId();

                foreach($getCartItems as $item){
                   $cartItem = new OrdersProduct;
                   $cartItem->order_id = $order_id;
                   $cartItem->user_id = Auth::user()->id;
                   $getProductDetails = Product::select('product_code','product_name','product_color','admin_id','vendor_id')->where('id',$item['product_id'])->first()->toArray();
                   /*dd($getProductDetails);*/

                   $cartItem->admin_id = $getProductDetails['admin_id'];
                   $cartItem->vendor_id = $getProductDetails['vendor_id'];
                   $cartItem->product_id = $item['product_id'];
                   $cartItem->product_code = $getProductDetails['product_code'];
                   $cartItem->product_name = $getProductDetails['admin_id'];
                   $cartItem->product_color = $getProductDetails['product_color'];
                   $cartItem->product_size = $item['size'];
                   $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                   $cartItem->product_price = $getDiscountAttributePrice['final_price'];
                   $cartItem->product_qty = $item['quantity'];
                   $cartItem->save();
                }
                
                //Insert Order Id in Session variable
                Session::put('order_id',$order_id);

                DB::commit();

                return redirect('thanks');
 
        }
        
      
        return view('front.products.checkout')->with(compact('deliveryAddresses','countries','getCartItems'));
    }
    
    public function thanks(){
        if(Session::has('order_id')){
            //Empty the cart
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('front.products.thanks');
        }else{
            return redirect('cart');
        }
    
    }
}
