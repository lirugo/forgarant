<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'product_prices';

    protected $fillable = [
        'product_id',
        'price',
        'date_start',
        'date_end',
        'currency',
    ];

    //
}
