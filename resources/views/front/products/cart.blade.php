<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
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
                        <a href="cart.html">Cart</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Cart-Page -->
    <div class="page-cart u-s-p-t-80">
        <div class="container">
        @if(Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error: </strong> <?php echo Session::get('error_message'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> <?php echo Session::get('success_message'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
            <div class="row">
                <div class="col-lg-12">
                    <div id="appendCartItems">
                    @include('front.products.cart_items')
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="button-area">
            <a href="{{ url('/') }}" class="continue">Continue Shopping</a>
            <a href="{{ url('/checkout') }}" class="checkout">Proceed to Checkout</a>
        </div>
<!-- Cart-Page /- -->
@endsection