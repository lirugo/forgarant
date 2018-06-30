<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(){
        //Get all products
        $products = Product::all();
        //Set product to view
        return view('product.index')->with('products', $products);
    }
}
