<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'price',
        'name',
        'description',
        'currency',
        'img',
    ];

    public function prices()
    {
        return $this->hasMany('App\Price');
    }
}
