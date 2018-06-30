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
                        <div class="card-header text-center">{{$product->name}}</div>
                        <div class="card-body">
                            <p class="card-text">{{$product->description}}</p>
                            <a href="#" class="btn btn-primary">Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
