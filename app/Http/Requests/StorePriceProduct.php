<?php

namespace App\Http\Requests;

use App\Product;
use Illuminate\Foundation\Http\FormRequest;

class StorePriceProduct extends FormRequest
{

    private $date_created;

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

        $this->date_created = date('Y-m-d', strtotime($date_created.' + 1 day'));

        return [
            'price' => 'required|numeric',
            'date_start' => 'required|date|before:date_end|after:'.$date_created,
            'date_end' => 'required|date|after:date_start',
            'currency' => 'required|in:' . implode(',', array_keys(config('currency.types'))),
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'date_start.after' => 'The price start date must be after the product creation date. Min start date it\'s '.$this->date_created,
        ];
    }
}
