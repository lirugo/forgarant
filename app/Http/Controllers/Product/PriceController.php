<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests\StorePriceProduct;
use App\Price;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PriceController extends Controller
{
    /**
     * PriceController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param StorePriceProduct $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePriceProduct $request,$id){
        //Get valid data
        $validated = $request->validated();

        //Persist to db
        Price::create([
            'product_id' => $id,
            'price' => $validated['price'],
            'date_start' => $validated['date_start'],
            'date_end' => $validated['date_end'],
            'currency' => $validated['currency'],
        ]);

        //Flash msg
        Session::flash('success', 'The price was successfully added.');

        //Redirect
        return redirect()->back();
    }

    public function delete($id){
        //Delete in db
        Price::destroy($id);

        //Flash msg
        Session::flash('success', 'The price was successfully deleted.');

        //Redirect
        return redirect()->back();
    }
}
