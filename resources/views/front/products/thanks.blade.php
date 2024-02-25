<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')

<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Cart</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="index.html">Home</a>
                </li>
                <li class="is-marked">
                    <a href="cart.html">Thanks</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="page-cart u-s-p-t-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" align="center">
                <h3>Your Order Has Been Placed Successfully!</h3>
                <p>Your order number is {{ Session::get('order_id') }} and Grand total is ₱ {{ Session::get('grand_total') }}</p>
            </div>
        </div>
    </div>
</div>

@endsection