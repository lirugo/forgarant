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
    /**
     * @param $product
     * @return Collection
     */
    private function priorityPriceSetLater($product){
        $chart = new Collection();

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

        return $chart;
    }

    /**
     * ProductController constructor.
     */
    public function __construct(){
        //
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        //Get all products
        $products = Product::all();

        //Set product to view
        return view('product.index')->with('products', $products);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        //Get current product
        $product = Product::find($id);

        //Create chart
        $population = Lava::DataTable();

        //Set chart
        $population->addDateColumn('Date')
            ->addNumberColumn('Price on '.$product->name);

        //Get collection with date for chart
        $chart = $this->priorityPriceSetLater($product);

        //Set data to chart
        foreach ($chart as $ch => $key){
            $population->addRow([$ch, $key]);
        }

        //Set chart to view
        Lava::AreaChart('Price', $population, [
            'title' => 'Price on '.$product->name,
            'legend' => [
                'position' => 'none'
            ]
        ]);

        //Set product data to view
        return view('product.show')->with('product',$product);
    }
}
