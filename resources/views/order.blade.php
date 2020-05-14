@extends('template')

@section('title')
    {{  $title ?? '' }}
@endsection

@section('content')

    <div class="container" id="order-template">
        <div class="col-xs-12">

            @include('templates.title')

            @include('templates.menu', ['visual' => 'active'])

            @include('templates.main-form-switcher', ['type' => 'visual'])
            @include('templates.main-form-begin')

            @include('orders.visual')

            @include('templates.main-form-end')

        </div>
    </div>

@endsection