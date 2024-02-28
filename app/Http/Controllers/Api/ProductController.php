<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Product;
use App\Models\Section;
use App\Models\ProductsImage;
use App\Models\Category;
use App\Models\Author;
use App\Models\ProductsFilter;
use Illuminate\Support\Facades\Validator;
use Auth;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json(['products'=>$products], 200);
    }
}