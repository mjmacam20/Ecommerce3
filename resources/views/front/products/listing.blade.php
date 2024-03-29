<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Shop</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="listing.html">Shop</a>
                </li>
            </ul>
        </div>
    </div>
    </div> 

    <!-- Page Introduction Wrapper /- -->
    <!-- Shop-Page -->
    <div class="page-shop u-s-p-t-80">
    <div class="container">
        <!-- Shop-Intro -->
        <div class="shop-intro">
            <ul class="bread-crumb">
                <li class="has-separator">
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <?php echo $categoryDetails['breadcrumbs'] ?>
            </ul>
        </div>
        <!-- Shop-Intro /- -->
        <div class="row">
            <!-- Shop-Left-Side-Bar-Wrapper -->
            @include('front.products.filters')
            <!-- Shop-Left-Side-Bar-Wrapper /- -->
            <!-- Shop-Right-Wrapper -->
            <div class="col-lg-9 col-md-9 col-sm-12">
                <!-- Page-Bar -->
                <div class="page-bar clearfix">
                    <div class="shop-settings">
                        <a id="list-anchor">
                            <i class="fas fa-th-list"></i>
                        </a>
                        <a id="grid-anchor" class="active">
                            <i class="fas fa-th"></i>
                        </a>
                    </div>
                    <!-- Toolbar Sorter 1  -->
                    <form name="sortProducts" id="sortProducts">

                    <div class="toolbar-sorter name="url" id="url"">
                        <div class="select-box-wrapper">
                            <label class="sr-only" for="sort-by">Sort By</label>
                            <select name="sort" id="sort" class="select-box">
                                <!-- <option selected="selected" value="">Sort By: Best Selling</option>-->
                                <option selected="" value="">Select</option>
                                <option value="product_latest" @if (isset($_GET['sort']) && $_GET['sort']=="product_latest") selected="" @endif>Sort By: Latest</option>
                                <option value="price_lowest"   @if (isset($_GET['sort']) && $_GET['sort']=="price_lowest") selected="" @endif>Sort By: Lowest Price</option>
                                <option value="price_highest"  @if (isset($_GET['sort']) && $_GET['sort']=="price_highest") selected="" @endif>Sort By: Highest Price</option>
                                <option value="name_a_z"  @if (isset($_GET['sort']) && $_GET['sort']=="name_a_z") selected=""  @endif>Sort By: Name A - Z</option>
                                <option value="name_z_a"  @if (isset($_GET['sort']) && $_GET['sort']=="name_z_a") selected="" @endif>Sort By: Name Z - A</option>
                                <!-- <option value="">Sort By: Best Rating</option> -->
                            </select>
                        </div>
                    </div>
                    </form>
                    <!-- //end Toolbar Sorter 1  -->
                    <!-- Toolbar Sorter 2  -->
                    <!-- <div class="toolbar-sorter-2">
                        <div class="select-box-wrapper">
                            <label class="sr-only" for="show-records">Show Records Per Page</label>
                            <select class="select-box" id="show-records">
                                <option selected="selected" value="">Show: 8</option>
                                <option value="">Show: 16</option>
                                <option value="">Show: 28</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="toolbar-sorter-2">
                        <div class="select-box-wrapper">
                            <label class="sr-only" for="show-records">Show Records Per Page</label>
                            <select class="select-box" id="show-records">
                                <option selected="selected" value="">Showing: {{count($categoryProducts) }}</option>
                                <option value="">Showing: All</option>
                            </select>
                        </div>
                    </div>
                    <!-- //end Toolbar Sorter 2  -->
                </div>
                <!-- Page-Bar /- -->
                <!-- Row-of-Product-Container -->
                <div class="row product-container list-style">

                    @foreach($categoryProducts as $product)
                    <div class="product-item col-lg-4 col-md-6 col-sm-6 ">
                        <div class="item">
                            <div class="image-container">
                                <a class="item-img-wrapper-link" href="{{ url ('product/'.$product['id']) }}">
                                    <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                    @if(!empty($product['product_image']) && file_exists($product_image_path))
                                    <img class="img-fluid" src="{{ asset($product_image_path)}}" alt="Product">
                                    @else
                                    <img class="img-fluid" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="Product">
                                    @endif
                                </a>

                            </div>
                            <div class="item-content">
                                <div class="what-product-is">
                                    <ul class="bread-crumb">
                                        <li style="display: none;"> <!---lagay ka ng class="has-separator" pag gusto mo mag separator yung "/" ganyan --->
                                            <a href="shop-v1-root-category.html">{{ $product['product_code'] }}</a>
                                        </li>
                                        <li style="display: none;">
                                            <a href="listing.html">{{ $product['product_color'] }}</a>
                                        </li>
                                        
                                        <li>
                                            <a href="listing.html">Author: {{ $product['author']['name'] }}</a>
                                        </li>
                                    </ul>
                                    <h6 class="item-title">
                                        <a href="{{ url ('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                    </h6>
                                    <div class="item-description">
                                       <p>{{ $product['description'] }}</p>
                                    </div>
                                    <!-- <div class="item-stars">
                                        <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                                            <span style='width:67px'></span>
                                        </div>
                                        <span>(23)</span>
                                    </div> -->
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
                            <?php $isProductNew = Product::isProductNew($product['id']); ?>
                            @if($isProductNew=="Yes")
                            <div class="tag new">
                                <span>NEW</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    
                </div>

                    @if(isset($_GET['sort']))
                        <div>{{ $categoryProducts->appends(['sort'=>$_GET['sort']])->links() }}</div>
                    @else
                        <div>{{ $categoryProducts->links() }}</div>
                    @endif
                <!-- if gusto ilagay description- -->
                <!--$categoryDetails['categoryDetails']['description'] }} -->
            </div>
            <!-- Shop-Right-Wrapper /- -->
           
            <!-- Shop-Pagination -->
            <!-- <div class="pagination-area">
                <div class="pagination-number">
                    <ul>
                        <li style="display: none">
                            <a href="shop-v1-root-category.html" title="Previous">
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </li>
                        <li class="active">
                            <a href="shop-v1-root-category.html">1</a>
                        </li>
                        <li>
                            <a href="shop-v1-root-category.html">2</a>
                        </li>
                        <li>
                            <a href="shop-v1-root-category.html">3</a>
                        </li>
                        <li>
                            <a href="shop-v1-root-category.html">...</a>
                        </li>
                        <li>
                            <a href="shop-v1-root-category.html">10</a>
                        </li>
                        <li>
                            <a href="shop-v1-root-category.html" title="Next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>-->
            <!-- Shop-Pagination /- -->
        </div>
    </div>
    </div>
    <!-- Shop-Page /- -->
@endsection