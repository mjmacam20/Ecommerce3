<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')

<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Order #{{ $orderDetails['id'] }} Details</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/')}}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="{{ url('user/orders')}}">Orders</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="page-cart u-s-p-t-80">
    <div class="container">
        <div class="row">
            <table class="table table-striped table-borderless">
               <tr class="table-primary"><td colspan="2"><strong>Order Details</strong></td></tr>
               <tr><td>Order Date</td><td>{{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])) }}</td></tr>
               <tr><td>Order Status</td><td>{{ $orderDetails['order_status'] }} </td></tr>
               <tr><td>Order Total</td><td>{{ $orderDetails['order_status'] }} </td></tr>
               <tr><td>Shipping Charges<td>{{ $orderDetails['shipping_charges'] }} </td> </td></tr>
               <tr><td>Payment Method<td>{{ $orderDetails['payment_method'] }} </td></td></tr>
            </table>

            <table class="table table-striped table-borderless">
                    <tr class="table-primary">
                        <th>Product Image</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Product Size</th>
                        <th>Product Color</th>
                        <th>Product Qty</th>
                    </tr>
                    @foreach($orderDetails['orders_products'] as $product)
                        <tr>
                            <td>
                                @php $getProductImage = Product::getProductImage($product['product_id']) @endphp
                                <a target="_blank" href="{{ url('product/'.$product['product_id']) }}"><img style="width:80px" src="{{ asset('front/images/product_images/small/'.$getProductImage) }}"></a>
                            </td>
                            <th>{{ $product['product_code'] }}</th>
                            <th>{{ $product['product_name'] }}</th>
                            <th>{{ $product['product_size'] }}</th>
                            <th>{{ $product['product_color'] }}</th>
                            <th>{{ $product['product_qty'] }}</th>
                        </tr>
                    @endforeach
            </table>
            <table class="table table-striped table-borderless">
               <tr class="table-primary"><td colspan="2"><strong>Delivery Address</strong></td></tr>
               <tr><td>Name</td><td>{{ $orderDetails['name'] }}</td></tr>
               <tr><td>Address</td><td>{{ $orderDetails['address'] }} </td></tr>
               <tr><td>City</td><td>{{ $orderDetails['city'] }} </td></tr>
               <tr><td>State<td>{{ $orderDetails['state'] }} </td> </td></tr>
               <tr><td>Country<td>{{ $orderDetails['country'] }} </td></td></tr>
               <tr><td>Zipcode<td>{{ $orderDetails['zipcode'] }} </td></td></tr>
               <tr><td>Mobile<td>{{ $orderDetails['mobile'] }} </td></td></tr>
            </table>
        </div>
    </div>
</div>

@endsection