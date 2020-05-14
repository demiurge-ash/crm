@extends('layouts.app')

@section('title')Редактирование заказа | @endsection

@section('content')

    @if($user->isDesigner())
        @include('dashboards.order-show-designer')
        <br>
        @include('dashboards.designer-file-upload')
    @else
        @include('dashboards.order-show')
    @endif

@endsection 