@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    {!! Form::Open() !!}
                        <div class="card-header text-center">Create new product</div>
                        <div class="card-body">
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter product name', 'required']) !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control m-t-10', 'placeholder' => 'Enter product description', 'required']) !!}
                            {!! Form::number('price', null, ['class' => 'form-control m-t-10', 'min' => '1', 'placeholder' => 'Enter product price', 'required']) !!}
                            <select name="currency" class="form-control m-t-10" required>
                                <option value="">Select currency</option>
                                @foreach (config('currency.types') as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            {!! Form::label('Upload product image'); !!}
                            {!! Form::file('img', ['class' => 'm-t-10', 'accept' => 'image/*']); !!}
                            <hr>
                            <a href="{{url('/products')}}" class="btn btn-outline-primary">Back to products</a>
                            {!! Form::submit('Create new product',['class' => 'btn btn-outline-success pull-right']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
