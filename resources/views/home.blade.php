@extends('layouts.app')

@section('content')

    @include('dashboards.new-order')

    @include('dashboards.orders')

    @include('dashboards.working-days')

    @include('dashboards.vacation')

    @include('templates.copyright')

@endsection
