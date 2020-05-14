@extends('template')

@section('title')
    {{ $title ?? '' }}
@endsection

@section('content')

    <div class="container" id="order-template">
        <div class="col-xs-12">

            @include('templates.title')

            @include('templates.menu', ['promo' => 'active'])

            @include('templates.main-form-switcher', ['type' => 'promo'])
            @include('templates.main-form-begin')

            @include('orders.promo')

            @include('templates.main-form-end')

        </div>
    </div>

@endsection