@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img class="card-img-top" src="{{ url('storage/products/img/'.$product->img) }}" alt="{{$product->name}}">
                    <div class="card-header text-center">{{$product->name}}</div>
                    <div class="card-body">
                        <p class="card-text">{{$product->description}}</p>
                    </div>
                    <div class="card-footer bg-transparent border-success">Price - {{$product->prices->last()->price}} | {{$product->prices->last()->currency}}</div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header text-center">Graph price</div>
                    <div class="card-body">
                        // Graph
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-t-20">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">Change price product</div>
                    <div class="card-body">
                        // Select date start and end
                    </div>
                    <div class="card-footer bg-transparent border-success">
                        <a class="btn btn-outline-success">Update</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection