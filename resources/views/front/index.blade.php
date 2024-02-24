<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<!-- Main-Slider -->
<div class="default-height ph-item">
    <div class="slider-main owl-carousel">
        @foreach($sliderBanners as $banner)
        <div class="bg-image">
            <div class="slide-content">
                <h1><a @if(!empty($banner['link'])) href="{{ url($banner['link']) }}" @else href="javascript:;" @endif><img title="{{ $banner['title'] }}" alt="{{ $banner['title'] }}" src="{{ asset('front/images/banner_images/'.$banner['image']) }}"></a></h1>
                <h2>{{ $banner['title'] }}</h2>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Main-Slider /- -->
@if(isset($fixBanners[0]['image']))
<!-- Banner-Layer -->
<div class="banner-layer">
    <div class="container">
        <div class="image-banner">
            <a target="_blank" rel="nofollow" href="{{ url($fixBanners[0]['link']) }}" class="mx-auto banner-hover effect-dark-opacity">
                <img class="img-fluid" src="{{ asset('front/images/banner_images/'.$fixBanners[0]['image']) }}" alt="{{ $fixBanners[0]['alt'] }}" title="{{ $fixBanners[0]['title'] }}">
            </a>
        </div>
    </div>
</div>
<!-- Banner-Layer /- -->
@endif
<!-- Top Collection -->
<section class="section-maker">
    <div class="container">
        <div class="sec-maker-header text-center">
            <h3 class="sec-maker-h3">TOP PRODUCTS</h3>
            <ul class="nav tab-nav-style-1-a justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#men-latest-products" id="newArrivalsSection" >New Arrivals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#men-best-selling-products" id="bestSellersSection">Best Sellers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#discounted-products" id="discountedSection">Discounted Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#men-featured-products" id="featuredSection">Featured Products</a>
                </li>
            </ul>
        </div>

        
        <div class="wrapper-content">
            <div class="outer-area-tab">
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="men-latest-products">
                        <div class="row">
                            <div class="row" data-item="5">
                                @foreach($newProducts as $product)
                                <?php //echo "<pre>"; print_r($product); die;?>
                                <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                @if(!empty($product['product_image']) && file_exists( $product_image_path))
                                                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                                @else
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="Product">
                                                @endif
                                            </a>
                                             <!--<div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                            </div>-->
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>(0)</span>
                                                </div>
                                            </div>
                                            <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                            @if($getDiscountPrice>0)
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    ₱ {{ $getDiscountPrice }}
                                                </div>
                                                <div class="item-old-price">
                                                    ₱ {{ $product['product_price'] }}
                                                </div>
                                            </div>
                                            @else
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    ₱ {{ $product['product_price'] }}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="tag new">
                                            <span>NEW</span>
                                        </div>
                                    </div>
                                @endforeach                          
                            </div>

                        </div>
                    </div>
                    
                    <div class="tab-pane show fade" id="men-best-selling-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                                
                                @foreach($bestSellers as $product)
                                <?php //echo "<pre>"; print_r($product); die;?>
                                <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                @if(!empty($product['product_image']) && file_exists( $product_image_path))
                                                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                                @else
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="Product">
                                                @endif
                                            </a>
                                             <!--<div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                            </div>-->
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>(0)</span>
                                                </div>
                                            </div>
                                            <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                            @if($getDiscountPrice>0)
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    ₱ {{ $getDiscountPrice }}
                                                </div>
                                                <div class="item-old-price">
                                                    ₱ {{ $product['product_price'] }}
                                                </div>
                                            </div>
                                            @else
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    ₱ {{ $product['product_price'] }}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="tag new">
                                            <span>NEW</span>
                                        </div>
                                    </div>
                                @endforeach                          
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="discounted-products">
                    <div class="row">
                            <div class="row" data-item="4">

                                @foreach($discountedProducts as $product)
                                <?php //echo "<pre>"; print_r($product); die;?>
                                <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                @if(!empty($product['product_image']) && file_exists( $product_image_path))
                                                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                                @else
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="Product">
                                                @endif
                                            </a>
                                             <!--<div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                            </div>-->
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>(0)</span>
                                                </div>
                                            </div>
                                            <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                            @if($getDiscountPrice>0)
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    ₱ {{ $getDiscountPrice }}
                                                </div>
                                                <div class="item-old-price">
                                                    ₱ {{ $product['product_price'] }}
                                                </div>
                                            </div>
                                            @else
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    ₱ {{ $product['product_price'] }}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="tag new">
                                            <span>NEW</span>
                                        </div>
                                    </div>
                                @endforeach 
                                
                            </div>                      
                        </div>
                    </div>
                    <div class="tab-pane fade" id="men-featured-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">

                            @foreach($featuredProducts as $product)
                                <?php //echo "<pre>"; print_r($product); die;?>
                                <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                @if(!empty($product['product_image']) && file_exists( $product_image_path))
                                                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                                @else
                                                <img class="img-fluid" src="/front/images/product_images/small/no-image.png" alt="Product">
                                                @endif
                                            </a>
                                            <!--<div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                            </div>-->
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>(0)</span>
                                                </div>
                                            </div>
                                            <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                            @if($getDiscountPrice>0)
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    ₱ {{ $getDiscountPrice }}
                                                </div>
                                                <div class="item-old-price">
                                                    ₱ {{ $product['product_price'] }}
                                                </div>
                                            </div>
                                            @else
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    ₱ {{ $product['product_price'] }}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="tag new">
                                            <span>NEW</span>
                                        </div>
                                    </div>
                                @endforeach 


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Top Collection /- -->
@if(isset($fixBanners[1]['image']))
<!-- Banner-Layer -->
<div class="banner-layer">
    <div class="container">
        <div class="image-banner">
            <a target="_blank" rel="nofollow" href="{{ url($fixBanners[1]['link']) }}" class="mx-auto banner-hover effect-dark-opacity">
                <img class="img-fluid" src="{{ asset('front/images/banner_images/'.$fixBanners[1]['image']) }}" alt="{{ $fixBanners[1]['alt'] }}" title="{{ $fixBanners[1]['title'] }}">
            </a>
        </div>
    </div>
</div>

@endif


@endsection
