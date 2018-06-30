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

    public function show($id){
        //Get current product
        $product = Product::find($id);
        //Set product to view
        return view('product.show')->with('product',$product);
    }
}
