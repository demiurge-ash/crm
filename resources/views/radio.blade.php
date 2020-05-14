@extends('template')

@section('title')
    {{ $title ?? '' }}
@endsection

@section('content')

    <div class="container" id="order-template">
        <div class="col-xs-12">

            @include('templates.title')

            @include('templates.menu', ['radio' => 'active'])

            @include('templates.main-form-switcher', ['type' => 'radio'])
            @include('templates.main-form-begin')

            @include('orders.radio')

            @include('templates.main-form-end')

        </div>
    </div>

@endsection