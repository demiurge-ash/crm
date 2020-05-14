@extends('layouts.app')

@section('title')
    Учёт рабочего времени
@endsection

@section('content')

    @include('worktime.dashboards.select-days')

    @include('worktime.dashboards.days')

@endsection
