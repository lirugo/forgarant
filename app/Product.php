<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function prices()
    {
        return $this->hasMany('App\Price');
    }
}
