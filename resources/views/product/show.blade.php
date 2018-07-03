@extends('layouts.app')

@section('stylesheets')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-3">
                <div class="card h-100">
                    <img class="card-img-top" src="{{ url('storage/products/img/'.$product->img) }}" alt="{{$product->name}}">
                    <div class="card-header text-center">{{$product->name}}</div>
                    <p class="m-no text-center bg-info text-light"><small>Date created - {{$product->created_at}}</small></p>
                    <div class="card-body">
                        <p class="card-text">{{$product->description}}</p>
                    </div>
                    <div class="card-footer bg-transparent border-success text-center">Price - {{number_format($product->price,2)}} | {{$product->currency}}</div>
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
                    <div class="card-footer bg-transparent border-success">
                        <p class="text-right text-muted m-no"><small>Last updated - </small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-t-20">
            <div class="col-md-3">
                @guest
                <div class="card">
                    <div class="card-header text-center">Please login to add a price</div>
                    <div class="card-body text-center">
                        <i class="fa fa-lock fa-5x"></i>
                        <a href="{{url('/login')}}" class="btn btn-outline-primary btn-block"><i class="fa fa-sign-in"></i> {{__('Login')}}</a>
                    </div>
                </div>
                @else
                <div class="card h-100">
                    {!! Form::model($product,['route' => ['products.store',$product->id], 'method' => 'POST']) !!}
                    <div class="card-header text-center">Add a price to product</div>
                    <div class="card-body">
                        {!! Form::hidden('product_id', $product->id) !!}
                        {!! Form::text('date_start', null, ['class' => 'form-control datepicker_start m-t-10', 'placeholder' => 'Select start date', 'required']) !!}
                        {!! Form::text('date_end', null, ['class' => 'form-control datepicker_end m-t-10', 'placeholder' => 'Select end date', 'required']) !!}
                        {!! Form::number('price', null, ['class' => 'form-control m-t-10', 'min' => '1', 'placeholder' => 'Enter price', 'required']) !!}
                        <select name="currency" class="form-control m-t-10" required>
                            <option value="">Select currency</option>
                            @foreach (config('currency.types') as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <hr>
                        {!! Form::submit('Add', ['class' => 'btn btn-outline-success btn-block m-t-10']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                @endguest
            </div>
            <div class="col-md-9">
                <div class="card h-100">
                    <div class="card-header text-center">Graph - Priority is the price set on smaller time</div>
                    <div class="card-body">
                        {{--Graphs--}}
                        <div id="priority_price_set_smaller_time"></div>
                        @areachart('PriorityPriceSetSmallerTime', 'priority_price_set_smaller_time')
                    </div>
                    <div class="card-footer bg-transparent border-success">
                        <p class="text-right text-muted m-no"><small>Last updated - </small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-t-20">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">Quick actions</div>
                    <div class="card-body text-center">
                        @guest
                            <i class="fa fa-lock fa-5x"></i>
                            <a href="{{url('/login')}}" class="btn btn-outline-primary btn-block"><i class="fa fa-sign-in"></i> {{__('Login')}}</a>
                        @else
                            {!! Form::open(['route' => ['products.delete',$product->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('Delete product',['class' => 'btn btn-outline-danger btn-block']) !!}
                            {!! Form::close() !!}
                        @endguest
                            <a href="{{url('/products')}}" class="btn btn-outline-primary btn-block m-t-10">{{__('Go to products')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header text-center">All prices</div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date start</th>
                                <th scope="col">Date end</th>
                                <th scope="col">Price</th>
                                <th scope="col">Currency</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product->prices as $price)
                                <tr>
                                    <th scope="row">{{$price->id}}</th>
                                    <td>{{$price->date_start}}</td>
                                    <td>{{$price->date_end}}</td>
                                    <td>{{$price->price}}</td>
                                    <td>{{$price->currency}}</td>
                                    <td>
                                        @guest
                                            <a href="{{url('/login')}}" class="btn btn-outline-primary btn-sm btn-block">{{__('Login')}}</a>
                                        @else
                                            {!! Form::open(['route' => ['products.price.delete',$price->id], 'method' => 'DELETE']) !!}
                                            {!! Form::submit('Delete',['class' => 'btn btn-outline-danger btn-sm btn-block']) !!}
                                            {!! Form::close() !!}
                                        @endguest
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
            $('.datepicker_start').datepicker({
                format: 'yyyy-mm-dd',
            });
            $('.datepicker_end').datepicker({
                format: 'yyyy-mm-dd'
            });
        });
    </script>
@endsection
