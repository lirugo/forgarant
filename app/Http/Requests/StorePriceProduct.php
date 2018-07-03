<?php

namespace App\Http\Requests;

use App\Product;
use Illuminate\Foundation\Http\FormRequest;

class StorePriceProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //!IMPORTANT! Its so dirty, I will rewrite this piece of validation...
        $productId = $_POST['product_id'];
        $date_created = Product::find($productId)->first()->prices()->first()->created_at;

        return [
            'price' => 'required|numeric',
            'date_start' => 'required|date|before:date_end|after:'.$date_created,
            'date_end' => 'required|date|after:date_start',
            'currency' => 'required|in:' . implode(',', array_keys(config('currency.types'))),
        ];
    }
}
