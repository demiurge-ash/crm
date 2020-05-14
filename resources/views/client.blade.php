@extends('layouts.app')

@section('title')Информация о клиенте | @endsection

@section('content')

    @include('dashboards.client')

    @include('dashboards.client-orders')

@endsection
