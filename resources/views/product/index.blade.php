@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Our Products</div>
                </div>
            </div>
        </div>

        <div class="row m-t-20">
            @foreach($products as $product)
                <div class="col-md-3">
                    <div class="card">
                        <img class="card-img-top" src="{{ url('storage/products/img/'.$product->img) }}" alt="{{$product->name}}">
                        <div class="card-header text-center border-success">{{$product->name}}</div>
                        <div class="card-body">
                            <p class="card-text">{{ strlen($product->description) > 60 ? substr($product->description,0,57).'...' : $product->description }}</p>
                            <a href="{{url('products/'.$product->id)}}" class="btn btn-primary">Details</a>
                        </div>
                        <div class="card-footer bg-transparent border-success">Price - {{number_format($product->price,2)}} | {{$product->currency}}</div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
