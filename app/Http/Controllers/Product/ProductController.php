<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests\CreateProduct;
use App\Price;
use App\Product;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Lava;
use Image;

class ProductController extends Controller
{
    /**
     * @param $product
     * @return Collection
     */
    private function priorityPriceSetLater($product){
        $chart = new Collection();

        //Find max|min date
        $priceEarly = $product->prices()->first();
        $priceLate = $priceEarly;
        foreach($product->prices as $price){
            if($priceEarly->date_start > $price->date_start)
                $priceEarly = $price;

            if($priceLate->date_end < $price->date_end)
                $priceLate = $price;
        }
        while (strtotime($priceEarly->date_start) <= strtotime($priceLate->date_end)) {
            $chart->put($priceEarly->date_start, $priceEarly->price);
            $priceEarly->date_start = date ("Y-m-d", strtotime("+1 day", strtotime($priceEarly->date_start)));
        }

        foreach($product->prices as $price){
            // Start date
            $dateStart = $price->date_start;
            // End date
            $dateEnd = $price->date_end ? $price->date_end : date('Y-m-d');
            while (strtotime($dateStart) <= strtotime($dateEnd)) {
                $chart->put($dateStart, $price->price);
                $dateStart = date ("Y-m-d", strtotime("+1 day", strtotime($dateStart)));
            }
        }
        return $chart;
    }

    /**
     * @param $product
     * @return Collection
     */
    private function priorityPriceSetSmallerTime($product){
        //Create collection
        $chart = new Collection();

        //Get all prices from product
        $prices = $product->prices;

        //Find max|min date
        $priceEarly = $product->prices()->first();
        $priceLate = $priceEarly;
        foreach($product->prices as $price){
            if($priceEarly->date_start > $price->date_start)
                $priceEarly = $price;

            if($priceLate->date_end < $price->date_end)
                $priceLate = $price;
        }
        while (strtotime($priceEarly->date_start) <= strtotime($priceLate->date_end)) {
            $chart->put($priceEarly->date_start, $priceEarly->price);
            $priceEarly->date_start = date ("Y-m-d", strtotime("+1 day", strtotime($priceEarly->date_start)));
        }

        //Set different between date start and date and
        foreach($prices as $price){
            //Start date
            $dateStart = strtotime($price->date_start);

            //End date
            $dateEnd = strtotime($price->date_end ? $price->date_end : date('Y-m-d'));

            //Set different
            $dateDiff = $dateEnd - $dateStart;
            $price->different = round($dateDiff / (60 * 60 * 24));
        }

        //Sorting by different
        $prices = $prices->sortByDesc('different');

        //Set collection
        foreach($prices as $price){
            // Start date
            $dateStart = $price->date_start;
            // End date
            $dateEnd = $price->date_end ? $price->date_end : date('Y-m-d');

            while (strtotime($dateStart) <= strtotime($dateEnd)) {
                $chart->put($dateStart, $price->price);
                $dateStart = date ("Y-m-d", strtotime("+1 day", strtotime($dateStart)));
            }
        }

        //Return collection
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
        $priorityPriceSetLater = Lava::DataTable();
        $priorityPriceSetSmallerTime = Lava::DataTable();

        //Set chart
        $priorityPriceSetLater->addDateColumn('Date')
            ->addNumberColumn('Price on '.$product->name);
        $priorityPriceSetSmallerTime->addDateColumn('Date')
            ->addNumberColumn('Price on '.$product->name);

        //Get collection with date for chart
        $chartPriceSetLater = $this->priorityPriceSetLater($product);
        $chartPriceSetSmallerTime = $this->priorityPriceSetSmallerTime($product);

        //Set data to chart
        foreach ($chartPriceSetLater as $ch => $key){
            $priorityPriceSetLater->addRow([$ch, $key]);
        }
        foreach ($chartPriceSetSmallerTime as $ch => $key){
            $priorityPriceSetSmallerTime->addRow([$ch, $key]);
        }

        //Set chart to view
        Lava::AreaChart('PriorityPriceSetLater', $priorityPriceSetLater, [
            'title' => 'Price on '.$product->name,
            'legend' => [
                'position' => 'none'
            ]
        ]);
        Lava::AreaChart('PriorityPriceSetSmallerTime', $priorityPriceSetSmallerTime, [
            'title' => 'Price on '.$product->name,
            'legend' => [
                'position' => 'none'
            ]
        ]);

        //Set product data to view
        return view('product.show')->with('product',$product);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        //Delete in db
        Product::destroy($id);

        //Flash msg
        Session::flash('success', 'The product was successfully deleted.');

        //Redirect
        return redirect()->to(url('/products'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('product.create');
    }

    /**
     * @param CreateProduct $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putCreate(CreateProduct $request){
        //Get valid data
        $validated = $request->validated();

        //Upload img on server
        $img = $request->file('img');
        $fileName = time() . '.' . $img->getClientOriginalExtension();
        Image::make($img)->resize(286, 180)->save( public_path('/storage/products/img/' . $fileName ) );

        //Persist to db
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'currency' => $validated['currency'],
            'img' => $fileName,
        ]);

        //Create default price
        Price::create([
            'product_id' => $product->id,
            'price' => $validated['price'],
            'date_start' => date('Y-m-d'),
            'date_end' => Carbon::now()->addMonths(2),
            'currency' => $validated['currency'],
        ]);

        //Flash msg
        Session::flash('success', 'The product was successfully created.');

        //Redirect to new product
        return redirect()->to(url('/products/'.$product->id));
    }
}
