@extends('template')

@section('title')
    {{ $title ?? '' }}
@endsection

@section('content')

    <div class="container" id="order-template">
        <div class="col-xs-12">

            @include('templates.title')

            @include('templates.menu', ['photo' => 'active'])

            @include('templates.main-form-switcher', ['type' => 'photo'])
            @include('templates.main-form-begin')

            @include('orders.photo')

            @include('templates.main-form-end')

        </div>
    </div>

@endsection