@extends('layouts.app')

@section('stylesheets')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection

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
                    <div class="card-footer bg-transparent border-success">Price - {{number_format($product->price,2)}} | {{$product->currency}}</div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header text-center">Graph - Priority is the price set later</div>
                    <div class="card-body">
                        {{--Graphs--}}
                        <div id="priority_price_set_later"></div>
                        @areachart('PriorityPriceSetLater', 'priority_price_set_later')
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-t-20">
            <div class="col-md-3">
                <div class="card">
                    @guest
                        <div class="card-header text-center">Add a price to product</div>
                        <div class="card-body text-center">
                            <a href="{{url('/login')}}" class="btn btn-outline-primary btn-block">Login</a>
                            <small>Login to add price</small>
                        </div>
                    @else
                        {!! Form::open(['route' => ['products.store',$product->id], 'method' => 'POST']) !!}
                        <div class="card-header text-center">Add a price to product</div>
                        <div class="card-body">
                            {!! Form::text('date_start', null, ['class' => 'form-control datepicker m-t-10', 'placeholder' => 'Select start date', 'required', 'readonly']) !!}
                            {!! Form::text('date_end', null, ['class' => 'form-control datepicker m-t-10', 'placeholder' => 'Select end date', 'required', 'readonly']) !!}
                            {!! Form::number('price', null, ['class' => 'form-control m-t-10', 'placeholder' => 'Enter price', 'required']) !!}
                            <select name="currency" class="form-control m-t-10" required>
                                <option value="">Select currency</option>
                                @foreach (config('currency.types') as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="card-footer bg-transparent border-success">
                            {!! Form::submit('Add', ['class' => 'btn btn-outline-success btn-block']) !!}
                        </div>
                        {!! Form::close() !!}
                    @endguest
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header text-center">Graph - Priority is the price set on smaller time</div>
                    <div class="card-body">
                        {{--Graphs--}}
                        <div id="priority_price_set_smaller_time"></div>
                        @areachart('PriorityPriceSetSmallerTime', 'priority_price_set_smaller_time')
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-t-20">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">Header</div>
                    <div class="card-body">
                        // Left side bar
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header text-center">All prices</div>
                    <div class="card-body">
                       // Table
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script
            src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
        });
    </script>
@endsection
