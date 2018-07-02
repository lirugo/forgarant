<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Khill\Lavacharts\Lavacharts;
use Lava;

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
        $chart = new Collection();

        $population = Lava::DataTable();

        $population->addDateColumn('Date')
            ->addNumberColumn('Price on '.$product->name);

        foreach($product->prices as $price){
            // Start date
            $date = $price->date_start;
            // End date
            $end_date = $price->date_end ? $price->date_end : date('Y-m-d');

            while (strtotime($date) <= strtotime($end_date)) {
                $chart->put($date, $price->price);
                $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
            }
        }

        foreach ($chart as $ch => $key){
            $population->addRow([$ch, $key]);
        }

        Lava::AreaChart('Price', $population, [
            'title' => 'Price on '.$product->name,
            'legend' => [
                'position' => 'none'
            ]
        ]);
        //Set product to view
        return view('product.show')->with('product',$product);
    }
}
